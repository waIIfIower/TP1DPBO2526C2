// Representasi entitas Sesi Tayang Bioskop
public class SesiTayang
{
    // Enkapsulasi atribut state
    private String id_sesi;
    private String judul_film;
    private String jadwal;
    private double harga;

    // Constructor untuk inisialisasi awal
    public SesiTayang(String id_sesi_baru, String judul_film_baru, String jadwal_baru, double harga_baru)
    {
        this.id_sesi = id_sesi_baru; 
        this.judul_film = judul_film_baru; 
        this.jadwal = jadwal_baru; 
        this.harga = harga_baru; 
    }

    // --- Accessor (Getter) ---
    public String getId()
    {
        return id_sesi; 
    }

    public String getJudul()
    {
        return judul_film; 
    }

    public String getJadwal()
    {
        return jadwal; 
    }

    public double getHarga()
    {
        return harga; 
    }

    // --- Mutator (Setter) ---
    public void setId(String id_sesi)
    {
        this.id_sesi = id_sesi; 
    }

    public void setJudul(String judul_film)
    {
        this.judul_film = judul_film; 
    }

    public void setJadwal(String jadwal)
    {
        this.jadwal = jadwal; 
    }

    // Setter khusus dengan validasi input harga
    public void setHarga(double harga)
    {
        if (harga > 0) 
        {
            this.harga = harga; 
        }
        else
        {
            System.out.println("Error: Harga harus lebih dari 0.");
        }
    }

    // Mencetak informasi entitas ke konsol
    void tampilkanData()
    {
        System.out.println("ID Sesi : " + getId());
        System.out.println("Judul Film : " + getJudul());
        System.out.println("Jadwal Tayang : " + getJadwal());
        System.out.printf("Harga Tiket : %.0f\n", getHarga());
    }
}