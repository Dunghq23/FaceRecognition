import face_recognition
import sys, os
from PIL import Image, ImageDraw, ImageFont

def load_encoding_file(file_path):
    names = []
    encodings = []

    with open(file_path, 'r') as file:
        lines = file.readlines()

    current_name = None
    current_encoding = []

    for line in lines:
        parts = line.strip().split(': ')

        if len(parts) == 2:
            if current_name is not None:
                names.append(current_name)
                encodings.append(current_encoding)

            current_name = parts[0]
            current_encoding = [float(value) for value in parts[1][1:-1].replace(']', '').split()]
        elif current_name is not None:
            current_encoding.extend([float(value) for value in line.strip().replace(']', '').split()])

    if current_name is not None:
        names.append(current_name)
        encodings.append(current_encoding)

    return names, encodings

# def recognize_faces(image_path, names, encodings, output_file):
#     image = face_recognition.load_image_file(image_path)
#     face_locations = face_recognition.face_locations(image)
#     face_encodings = face_recognition.face_encodings(image, face_locations)

#     results = []
#     for (top, right, bottom, left), face_encoding in zip(face_locations, face_encodings):
#         matches = face_recognition.compare_faces(encodings, face_encoding, tolerance=0.3)
#         name = "Unknown"

#         if True in matches:
#             first_match_index = matches.index(True)
#             name = names[first_match_index]

#         results.append({"top": top, "right": right, "bottom": bottom, "left": left, "name": name})

#     try:
#         # Tạo hoặc mở file resultPath và ghi dữ liệu vào đó
#         with open(output_file, "w", encoding="UTF-8") as file:
#             if len(results) != 0:
#                 try:
#                     if len(results) > 1:
#                         file.write("Phát hiện 2 khuôn mặt, vui lòng thử lại!")
#                     else:
#                         file.write(f"{results[0]['name']} ({results[0]['top']}, {results[0]['right']}, {results[0]['bottom']}, {results[0]['left']})")
#                 except Exception as e:
#                     file.write(f"Lỗi khi thực thi script Python: {e}")
#             else:
#                 file.write("Không có khuôn mặt được tìm thấy\n")
#     except Exception as e:
#         # Nếu xảy ra lỗi, ghi lỗi vào file
#         with open(output_file, "w", encoding="UTF-8") as file:
#             file.write(f"Lỗi khi thực thi script Python: {e}\n")

def recognize_faces(image_path, names, encodings, output_file):
    image = face_recognition.load_image_file(image_path)
    face_locations = face_recognition.face_locations(image)
    face_encodings = face_recognition.face_encodings(image, face_locations)

    results = []
    for (top, right, bottom, left), face_encoding in zip(face_locations, face_encodings):
        matches = face_recognition.compare_faces(encodings, face_encoding, tolerance=0.3)
        name = "Unknown"

        if True in matches:
            first_match_index = matches.index(True)
            name = names[first_match_index]

        results.append({"top": top, "right": right, "bottom": bottom, "left": left, "name": name})

    # Load the image using PIL
    pil_image = Image.fromarray(image)
    draw = ImageDraw.Draw(pil_image)
    font = ImageFont.load_default()

    for result in results:
        top, right, bottom, left = result["top"], result["right"], result["bottom"], result["left"]
        name = result["name"]

        if name == "Unknown":
            box_color = (255, 0, 0)  # Màu đỏ
            text_color = (255, 255, 255, 255)  # Màu trắng cho text
        else:
            box_color = (0, 0, 255)  # Màu xanh
            text_color = (255, 255, 255, 255)  # Màu trắng cho text

        # Vẽ hình chữ nhật quanh khuôn mặt
        draw.rectangle(((left, top), (right, bottom)), outline=box_color, width=2)

        # Vẽ nhãn tên bên dưới khuôn mặt
        text_width, text_height = draw.textbbox((0, 0), name, font=font)[2:]
        draw.rectangle(((left, bottom - text_height - 10), (right, bottom)), fill=box_color, outline=box_color)
        draw.text((left + 6, bottom - text_height - 5), name, fill=text_color, font=font)

    # Save the image to the same directory
    output_image_path = os.path.splitext(image_path)[0] + f"{name}.jpg"
    pil_image.save(output_image_path)
    
    # Print output path to verify
    print(f"Image saved at: {output_image_path}")

    try:
        # Tạo hoặc mở file resultPath và ghi dữ liệu vào đó
        with open(output_file, "w", encoding="UTF-8") as file:
            if len(results) != 0:
                try:
                    if len(results) > 1:
                        file.write("Phát hiện 2 khuôn mặt, vui lòng thử lại!")
                    else:
                        file.write(f"{results[0]['name']} ({results[0]['top']}, {results[0]['right']}, {results[0]['bottom']}, {results[0]['left']})")
                except Exception as e:
                    file.write(f"Lỗi khi thực thi script Python: {e}")
            else:
                file.write("Không có khuôn mặt được tìm thấy\n")
    except Exception as e:
        # Nếu xảy ra lỗi, ghi lỗi vào file
        with open(output_file, "w", encoding="UTF-8") as file:
            file.write(f"Lỗi khi thực thi script Python: {e}\n")


def encode_images(image_path, encoding_file, username):
    if not os.path.isfile(encoding_file):
        with open(encoding_file, 'w', encoding='utf-8') as file:
            file.write('')

    with open(encoding_file, 'a', encoding='utf-8') as encoding_file:
        image = face_recognition.load_image_file(image_path)
        encoding = face_recognition.face_encodings(image)

        if len(encoding) > 0:
            encoding_file.write(f"{username}: {encoding[0]}\n")
            os.remove(image_path)

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Usage: python main.py command [options]")
        sys.exit(1)

    command = sys.argv[1]

    if command == "recognize_faces":
        image_path = sys.argv[2]
        encodings_path = sys.argv[3]
        output_file = sys.argv[4]
        names, encodings = load_encoding_file(encodings_path)
        recognize_faces(image_path, names, encodings, output_file)
    elif command == "encode_images":
        image_path = sys.argv[2]
        encoding_file = sys.argv[3]
        username = sys.argv[4]
        encode_images(image_path, encoding_file, username)
    else:
        print("Unknown command")
        sys.exit(1)
