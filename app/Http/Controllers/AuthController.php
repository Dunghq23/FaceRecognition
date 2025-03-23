<?php

namespace App\Http\Controllers;

use App\Events\SystemLogEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login()
    {
        // User::create([
        //     'fk_employee_id' => 5,
        //     'username' => 'admin',
        //     'password' => Hash::make('123456')
        // ]);
        return view('auth.login');
    }

    public function checkLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6'
        ], [
            'username.required' => 'Vui lòng nhập tài khoản!',
            // 'username.min' => 'Tên tài khoản phải có ít nhất 6 ký tự!',
            'password.required' => 'Vui lòng nhập mật khẩu!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự!'
        ]);

        $credentials = $request->only('username', 'password');

        $userFound = User::where('username', $credentials['username'])->first();
        if (!$userFound) {
            return back()->with('error', 'Người dùng không tồn tại!')->withInput();
        }

        if (Auth::attempt($credentials)) {
            event(new SystemLogEvent( 'Đăng nhập hệ thống'));
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
        }

        // fail
        return back()->with('error', 'Mật khẩu không chính xác!')->withInput();
    }

    public function logout(Request $request)
    {
        event(new SystemLogEvent( 'Đăng xuất hệ thống'));

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login')->with('success', 'Đăng xuất thành công!');
    }

    public function savePhoto(Request $request)
    {
        if ($request->has('imageBase64')) {
            $imageData = $request->input('imageBase64');

            // Chuẩn bị dữ liệu ảnh để giải mã
            $imageData = str_replace('data:image/png;base64,', '', $imageData); // Loại bỏ phần header của base64
            $imageData = str_replace(' ', '+', $imageData); // Thay thế các khoảng trắng

            // Giải mã dữ liệu base64 thành dữ liệu nhị phân của ảnh
            $imageBinary = base64_decode($imageData);

            // Đường dẫn tới thư mục public/Storage
            $uploadPath = public_path('Storage/'); // Lưu trong thư mục public/Storage

            // Tạo thư mục nếu chưa tồn tại
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true); // Tạo thư mục với quyền 0777
            }

            // Tạo tên file duy nhất
            $filename = 'photo_' . date('Y-m-d-H-i-s') . '.png';

            // Đường dẫn tuyệt đối của file
            $filePath = $uploadPath . $filename;

            // Lưu ảnh vào thư mục public/Storage
            file_put_contents($filePath, $imageBinary);

            // Lấy đường dẫn URL của file đã lưu
            $publicPath = 'Storage/' . $filename;

            // Trả về đường dẫn URL
            return response()->json(['filepath' => $publicPath]);
        } else {
            return response()->json(['error' => 'Không có dữ liệu ảnh được gửi lên.'], 400);
        }
    }

    public function recognizeFace(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('imagePath')) {
                $imagePath = $request->input('imagePath');

                // Kiểm tra và lấy đường dẫn chính xác của các file và script Python
                $pythonScriptPath = storage_path('app/python/FaceRecognition.py');
                $encodingPath = storage_path('app/models/encodings.txt');
                $outputPath = storage_path('app/data/output.txt');
                if (!file_exists($outputPath)) {
                    $file = fopen($outputPath, 'w');
                    fclose($file);
                }

                if (!file_exists($encodingPath)) {
                    $file = fopen($encodingPath, 'w');
                    fclose($file);
                }

                $command = escapeshellcmd("py $pythonScriptPath recognize_faces $imagePath $encodingPath $outputPath");

                exec($command);

                // Đọc kết quả từ file output
                if (file_exists($outputPath)) {
                    $fullString = trim(file_get_contents($outputPath));
                    $parts = explode(' ', $fullString, 2);
                    $recognizedName = $parts[0];

                    if ($recognizedName === 'Unknown') {
                        // Nếu nhận dạng là "Unknown", di chuyển ảnh vào thư mục public/Storage/ImageUnknown
                        $newImagePath = public_path('Storage/ImageUnknown') . '/' . basename($imagePath);
                        copy($imagePath, $newImagePath);
                    }

                    return response()->json([
                        'command' => $command,
                        'recognizedName' => $recognizedName,
                        'imagePath' => $imagePath,
                        'encodingPath' => $encodingPath,
                        'outputPath' => $outputPath,
                        'pythonScriptPath' => $pythonScriptPath,
                    ]);
                } else {
                    return response()->json(['error' => 'Không tìm thấy file kết quả.'], 404);
                }
            } else {
                return response()->json(['error' => 'Không có dữ liệu imagePath được gửi lên.'], 400);
            }
        }
    }
}
