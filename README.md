# Hướng dẫn cài đặt

## Xóa các thư viện (Có thể không cần thiết)
Để xóa tất cả các thư viện đã cài đặt, bạn có thể thực hiện các lệnh sau:

```bash
pip freeze > Library.txt
```

```bash
pip uninstall -r Library.txt -y
```

## Yêu cầu
Để cài đặt các thư viện cần thiết, bạn cần đảm bảo rằng Python và pip đã được cài đặt trên hệ thống.

### Bước 1: Cài đặt `dlib`
Truy cập trang GitHub sau để tải gói `dlib`:

[https://github.com/z-mahmud22/Dlib_Windows_Python3.x](https://github.com/z-mahmud22/Dlib_Windows_Python3.x)

Sau đó, cài đặt gói `dlib` bằng lệnh:

```bash
python -m pip install dlib-19.24.99-cp312-cp312-win_amd64.whl
```

### Bước 2: Cài đặt `setuptools`
Cài đặt phiên bản `setuptools==69.5.1` bằng lệnh:

```bash
pip install setuptools==69.5.1
```

### Bước 3: Cài đặt `numpy`
Cài đặt phiên bản `numpy==1.26.4` bằng lệnh:

```bash
pip install numpy==1.26.4
```

### Bước 3: Cài đặt `face-recognition`
Cài đặt phiên bản `face-recognition==1.3.0` bằng lệnh:

```bash
pip install face-recognition==1.3.0
```