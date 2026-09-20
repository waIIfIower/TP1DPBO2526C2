#include <iostream>
#include <string>
#include <iomanip> // Memformat output presisi angka

using namespace std;

// Representasi entitas Sesi Tayang Bioskop
class SesiTayang
{
    private:
        // Enkapsulasi atribut untuk melindungi state objek
        string id_sesi;
        string judul_film;
        string jadwal;
        double harga;

    public:
    // Constructor untuk inisialisasi awal objek
    SesiTayang(string id, string judul, string jadwal, double harga)
    {
        setId(id);
        setJudul(judul);
        setJadwal(jadwal);
        setHarga(harga);
    }

    // --- Mutator (Setter) ---
    void setId(const string& id) 
    {
        this->id_sesi = id;
    }

    void setJudul(const string& judul) 
    {
        this->judul_film = judul;
    }

    void setJadwal(const string& jadwal) 
    {
        this->jadwal = jadwal;
    }

    void setHarga(const double& harga) 
    {
        this->harga = harga;
    }

    // --- Accessor (Getter) ---
    string getId() const
    {
        return id_sesi;
    }

    string getJudul() const
    {
        return judul_film;
    }

    string getJadwal() const
    {
        return jadwal;
    }

    double getHarga() const
    {
        return harga;
    }
    
    // Menampilkan detail sesi tayang ke konsol
    void tampilkanData() const 
    {
        cout << "ID Sesi : " << getId() << endl
            << "Judul Film : " << getJudul() << endl
            << "Jadwal Tayang : " << getJadwal() << endl
            << "Harga Tiket : " << fixed << setprecision(0) << getHarga() << endl;
    }
    
    // Destructor
    ~SesiTayang()
    {
    }
};