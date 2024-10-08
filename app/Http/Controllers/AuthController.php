<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // public function savePhoto(Request $request)
    // {
    //     if ($request->ajax()) {
    //         if ($request->has('imageBase64')) {
    //             $imageData = $request->input('imageBase64');

    //             // Chuẩn bị dữ liệu ảnh để giải mã
    //             $imageData = str_replace('data:image/png;base64,', '', $imageData); // Loại bỏ phần header của base64
    //             $imageData = str_replace(' ', '+', $imageData); // Thay thế các khoảng trắng

    //             // Giải mã dữ liệu base64 thành dữ liệu nhị phân của ảnh
    //             $imageBinary = base64_decode($imageData);

    //             // Đường dẫn tới thư mục trong storage/app
    //             $uploadPath = 'ImageRecognize/';

    //             // Tạo thư mục nếu chưa tồn tại
    //             if (!Storage::exists($uploadPath)) {
    //                 // Storage::makeDirectory($uploadPath, 0777, true, true);
    //                 Storage::makeDirectory($uploadPath);
    //             }

    //             // Tạo tên file duy nhất
    //             $filename = 'photo_' . date('Y-m-d-H-i-s') . '.png';

    //             // Lưu ảnh vào thư mục trong storage
    //             Storage::put($uploadPath . $filename, $imageBinary);

    //             // Lấy đường dẫn tuyệt đối của file đã lưu
    //             $filePath = Storage::path($uploadPath . $filename);

    //             // Trả về đường dẫn tuyệt đối
    //             return response()->json(['filepath' => realpath($filePath)]);
    //         } else {
    //             return response()->json(['error' => 'Không có dữ liệu ảnh được gửi lên.'], 400);
    //         }
    //     }
    // }


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
