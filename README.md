# Tugas-II3160-Teknologi-Sistem-Terintegrasi
Layanan Microservice menggunakan CI4

Program ini menyimpan data buku

## Cara Menjalankan Program
- Clone project

- Login Menggunakan admin dalam bentuk form data, {username : admin} dan {password : adminpassword}
  
```bash
  http://kelas-king.site:8080
```

- Membuat data buku baru dalam bentuk form data, yaitu {title, author, genre, isbn, published_date, availability_status}
```bash
  http://kelas-king.site:8080/books/create
```

- Mengupdate data buku dalam bentuk form data, yaitu {title, author, genre, isbn, published_date, availability_status} dengan id yang ingin diupdate
```bash
  http://kelas-king.site:8080/books/update/{id}
```

- Menghapus data buku dalam bentuk form data menggunakan id
```bash
  http://kelas-king.site:8080/books/delete/{id}
```

- Mengubah status buku
```bash
  http://kelas-king.site:8080/books/toggleAvailability/{id}
```

- Memperlihatkan semua data buku
```bash
  http://kelas-king.site:8080/books/show
```

- Memperlihatkan satu id data buku
```bash
  http://kelas-king.site:8080/books/show/{id}
```
