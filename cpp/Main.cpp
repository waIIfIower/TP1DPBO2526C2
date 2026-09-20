#include "SesiTayang.cpp"
#include <vector>
#include <limits>

using namespace std;

// Koleksi data dinamis untuk menyimpan objek SesiTayang
vector<SesiTayang> daftarSesi; 

// Validasi keberadaan ID untuk mencegah duplikasi
bool isIdExists(const string& id) {
    for (const auto& sesi : daftarSesi) 
    {
        if (sesi.getId() == id) 
        {
            return true; 
        }
    }
    return false; 
}

// Menampilkan antarmuka menu utama
void tampilkanMenu()
{
    cout << "\n<======== Menu Bioskop Cimahi 2067 ========>" << endl
        << "1. Tambah Data Sesi Tayang" << endl
        << "2. Tampilkan Semua Data Sesi Tayang" << endl
        << "3. Update Data Sesi Tayang" << endl
        << "4. Hapus Data Sesi Tayang" << endl
        << "5. Cari Data Sesi Tayang" << endl
        << "6. Keluar" << endl
        << "Masukkan pilihan: ";
}

// Modul untuk meregistrasi data sesi tayang baru
void tambahData()
{
    string id, judul, jadwal;
    double harga;

    cout << "\n--- Tambahkan Data Sesi Tayang ---" << endl;
    
    // Loop validasi memastikan ID unik
    do {
        cout << "\nId: ";
        cin >> id;
        if (isIdExists(id)) {
            cout << "ID sudah digunakan. Silakan masukkan ID lain." << endl;
        }
    } while (isIdExists(id)); 

    cin.ignore(numeric_limits<streamsize>::max(), '\n');
    cout << "\nJudul Film: ";
    getline(cin, judul); 

    cout << "\nJadwal Tayang: ";
    getline(cin, jadwal); 

    // Loop validasi input angka dan non-negatif
    while (true) {
        cout << "\nHarga: ";
        cin >> harga; 
        if (cin.fail() || harga <= 0)
        {
            cout << "Input tidak valid. Silakan masukkan angka positif." << endl;
            cin.clear(); 
            cin.ignore(numeric_limits<streamsize>::max(), '\n'); 
        }
        else
        {
            cin.ignore(numeric_limits<streamsize>::max(), '\n'); 
            break;
        }
    }

    // Instansiasi dan penambahan objek ke dalam vector
    daftarSesi.push_back(SesiTayang(id, judul, jadwal, harga)); 
    cout << "\nData berhasil ditambahkan" << endl; 
}

// Modul untuk menampilkan seluruh data tersimpan
void tampilkanData()
{
    cout << "\n--- Daftar Sesi Tayang ---" << endl;
    if (daftarSesi.empty())
    {
        cout << "\nData sesi tayang kosong" << endl;
    }
    
    // Iterasi untuk mencetak setiap objek
    for(const auto& sesi : daftarSesi)
    {
        sesi.tampilkanData(); 
        cout << "\n"; 
    }
}

// Modul untuk memperbarui data berdasarkan ID
void updateData()
{
    string id_update; 
    cout << "\n--- Update Data Sesi Tayang ---" << endl;
    cout << "Masukkan ID Sesi yang akan diupdate: ";
    cin >> id_update; 
    cin.ignore(numeric_limits<streamsize>::max(), '\n');
    
    // Pencarian objek target
    for (auto& sesi : daftarSesi)
    {
        if(sesi.getId() == id_update)
        {
            // Update ID dengan validasi duplikasi
            string id_baru;
            cout << "ID baru (" << sesi.getId() << "): ";
            getline(cin, id_baru);
            if (!id_baru.empty())
            {
                if (id_baru != sesi.getId() && isIdExists(id_baru))
                {
                    cout << "ID baru sudah digunakan. ID tidak diubah." << endl;
                }
                else
                {
                    sesi.setId(id_baru);
                }
            }

            // Update field opsional (hanya diubah jika input tidak kosong)
            string judul_baru;
            cout << "Judul Film baru (" << sesi.getJudul() << "): ";
            getline(cin, judul_baru);  
            if(!judul_baru.empty())
            {
                sesi.setJudul(judul_baru); 
            }

            string jadwal_baru;
            cout << "Jadwal Tayang baru (" << sesi.getJadwal() << "): ";
            getline(cin, jadwal_baru); 
            if(!jadwal_baru.empty())
            {
                sesi.setJadwal(jadwal_baru); 
            }

            string harga_baru;
            cout << "Harga baru (" << sesi.getHarga() << "): ";
            getline(cin, harga_baru); 
            if(!harga_baru.empty())
            {
                sesi.setHarga(stod(harga_baru)); 
            }

            cout << "\nData sesi tayang berhasil diupdate" << endl;
            return;
        }
    }
    cout << "Sesi tayang dengan ID " << id_update << " tidak ditemukan" << endl;
}

// Modul untuk menghapus objek dari koleksi berdasarkan ID
void hapusData()
{
    string id_hapus; 
    cout << "\n--- Hapus Data Sesi Tayang ---" << endl;
    cout << "Masukkan ID Sesi yang akan dihapus: ";
    cin >> id_hapus; 

    // Pencarian dan penghapusan menggunakan iterator
    for(auto iterator = daftarSesi.begin(); iterator != daftarSesi.end(); ++iterator)
    {
        if(iterator->getId() == id_hapus) 
        {
            daftarSesi.erase(iterator); 
            cout << "\nData sesi tayang berhasil dihapus" << endl;
            return;
        }
    }
    cout << "Sesi tayang dengan ID " << id_hapus << " tidak ditemukan" << endl;
}

// Modul pencarian data tunggal
void cariData()
{
    string id_cari; 
    bool found = false;
    cout << "\n--- Cari Data Sesi Tayang ---" << endl;
    cout << "Masukkan ID Sesi yang akan dicari: ";
    cin >> id_cari; 

    // Iterasi pencarian objek
    for(const auto& sesi : daftarSesi)
    {
        if(sesi.getId() == id_cari) 
        {
            cout << "\nData sesi tayang ditemukan" << endl;
            sesi.tampilkanData(); 
            found = true;
            return;
        }
    }
    if(!found){
        cout << "\nData sesi tayang tidak ditemukan" << endl;
    }
}

// Entry point program utama
int main(){
    int pilihan; 
    
    // Loop antarmuka program
    do
    {
        tampilkanMenu(); 
        cin >> pilihan; 
        
        switch (pilihan)
        {
            case 1: tambahData(); break; 
            case 2: tampilkanData(); break; 
            case 3: updateData(); break; 
            case 4: hapusData(); break; 
            case 5: cariData(); break; 
            case 6: cout << "Terima kasih telah menggunakan program ini" << endl; break; 
            default: cout << "Pilihan tidak valid. Coba lagi" << endl; 
        }
    } while (pilihan != 6); 
    return 0;
}