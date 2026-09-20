from SesiTayang import SesiTayang 

# List dinamis sebagai storage utama objek
daftarSesi = [] 

# Validator untuk memastikan identifier bersifat unik
def isIdExists(id_sesi):
    for sesi in daftarSesi: 
        if sesi.getId() == id_sesi: 
            return True 
    return False 

# Menampilkan antarmuka navigasi utama
def tampilkanMenu():
    print("\n<======== Menu Bioskop Cimahi 2067 ========>")
    print("1. Tambah Data Sesi Tayang")
    print("2. Tampilkan Semua Data Sesi Tayang")
    print("3. Update Data Sesi Tayang")
    print("4. Hapus Data Sesi Tayang")
    print("5. Cari Data Sesi Tayang")
    print("6. Keluar")

# Modul penyisipan entitas baru
def tambahData():
    print("\n--- Tambahkan Data Sesi Tayang ---")
    
    # Perulangan untuk menjamin validitas ID
    while True:
        id_sesi = input("Id: ") 
        if not isIdExists(id_sesi): 
            break
        print("Error: ID sudah terdaftar. Silakan gunakan ID unik.") 
    
    judul_film = input("Judul Film: ") 
    jadwal = input("Jadwal Tayang: ") 
            
    # Perulangan untuk menangani error konversi tipe data numerik
    while True:
        try:
            harga = float(input("Harga: "))
            if(harga < 0): 
                print("Error: Harga tidak boleh bernilai negatif.")
                continue 
            break
        except ValueError: 
            print("Error: Format input wajib berupa angka.")

    # Instansiasi objek baru dan penyimpanannya ke memori
    sesi_baru = SesiTayang(id_sesi, judul_film, jadwal, harga)
    daftarSesi.append(sesi_baru) 
    print("\nData berhasil ditambahkan")

# Modul untuk menampilkan daftar seluruh objek
def tampilkanData():
    print("\n--- Daftar Sesi Tayang ---")
    if not daftarSesi: 
        print("\nData sesi tayang kosong")
    else:
        for sesi in daftarSesi: 
            sesi.tampilkanData() 
            print() 

# Modul pembaruan spesifik atribut pada objek
def updateData():
    print("\n--- Update Data Sesi Tayang ---")
    id_update = input("Masukkan ID Sesi yang akan diupdate: ") 

    found = False 
    for sesi in daftarSesi: 
        if sesi.getId() == id_update: 
            found = True

            # Pemrosesan ID baru dengan jaminan tidak terjadi duplikasi
            id_baru = input(f"ID baru ({sesi.getId()}): ")
            if id_baru:  
                if id_baru != sesi.getId() and isIdExists(id_baru): 
                    print("ID sudah terdaftar di sistem. ID gagal diubah.")
                else:
                    sesi.setId(id_baru) 

            # Pembaruan string (dilewati jika input kosong)
            print(f"Judul Film baru ({sesi.getJudul()}): ", end="")
            judul_baru = input()  
            if judul_baru:
                sesi.setJudul(judul_baru)

            print(f"Jadwal Tayang baru ({sesi.getJadwal()}): ", end="")
            jadwal_baru = input() 
            if jadwal_baru:
                sesi.setJadwal(jadwal_baru)

            # Pembaruan numerik dengan exception handling
            print(f"Harga baru ({sesi.getHarga()}): ", end="")
            harga_baru = input() 
            if harga_baru:
                try:
                    harga_baru_float = float(harga_baru)
                    if harga_baru_float < 0:
                        print("Error: Harga tidak boleh bernilai negatif.")
                    else:
                        sesi.setHarga(harga_baru_float) 
                except ValueError: 
                    print("Error: Format input invalid. Data harga gagal diubah.")

            print("\nData sesi tayang berhasil diupdate")
            break

    if not found: 
        print(f"Sesi tayang dengan ID {id_update} tidak ditemukan di sistem.")

# Modul destruksi objek spesifik
def hapusData():
    print("\n--- Hapus Data Sesi Tayang ---")
    id_hapus = input("Masukkan ID Sesi yang akan dihapus: ") 

    found = False 
    for sesi in daftarSesi: 
        if sesi.getId() == id_hapus: 
            daftarSesi.remove(sesi) 
            found = True 
            print("\nData sesi tayang berhasil dihapus")
            break

    if not found: 
        print(f"Sesi tayang dengan ID {id_hapus} tidak ditemukan di sistem.")

# Modul penelusuran objek spesifik
def cariData():
    print("\n--- Cari Data Sesi Tayang ---")
    id_cari = input("Masukkan ID Sesi yang akan dicari: ") 

    found = False 
    for sesi in daftarSesi: 
        if sesi.getId() == id_cari: 
            print("\nData sesi tayang ditemukan:")
            sesi.tampilkanData() 
            found = True
            break

    if not found: 
        print(f"Sesi tayang dengan ID {id_cari} tidak ditemukan di sistem.")

# Entry point main program
def main():
    while True:
        tampilkanMenu() 
        pilihan = input("Pilihan: ") 

        if pilihan == '1': 
            tambahData() 
        elif pilihan == '2': 
            tampilkanData() 
        elif pilihan == '3': 
            updateData() 
        elif pilihan == '4': 
            hapusData() 
        elif pilihan == '5': 
            cariData() 
        elif pilihan == '6': 
            print("Terima kasih telah menggunakan program ini")
            break
        else:
            print("Pilihan menu tidak valid. Silakan coba lagi.")

if __name__ == "__main__":
    main()