
import java.util.Scanner;
import java.util.ArrayList;
import java.util.InputMismatchException;

public class Main
{
    // Koleksi dinamis untuk menyimpan daftar objek SesiTayang
    private static ArrayList<SesiTayang> daftarSesi = new ArrayList<>();
    // Utilitas untuk menangkap input I/O
    private static Scanner scanner = new Scanner(System.in);

    // Validasi pengecekan duplikasi ID
    private static boolean isIdExists(String id) {
        for (SesiTayang sesi : daftarSesi) 
        {
            if (sesi.getId().equals(id)) 
            {
                return true; 
            }
        }
        return false; 
    }

    // Menampilkan antarmuka navigasi
    private static void tampilkanMenu()
    {
        System.out.println("\n<======== Menu Bioskop Cimahi 2067 ========>");
        System.out.println("1. Tambah Data Sesi Tayang");
        System.out.println("2. Tampilkan Semua Data Sesi Tayang");
        System.out.println("3. Update Data Sesi Tayang");
        System.out.println("4. Hapus Data Sesi Tayang");
        System.out.println("5. Cari Data Sesi Tayang");
        System.out.println("6. Keluar");
        System.out.print("Masukkan pilihan: ");
    }

    // Modul pencatatan data objek baru
    private static void tambahData()
    {
        System.out.println("\n--- Tambahkan Data Sesi Tayang ---");
        String id;
        
        // Loop validasi jaminan ID unik
        do
        {
            System.out.print("\nId: ");
            id = scanner.nextLine(); 
            if (isIdExists(id))
            {
                System.out.println("ID sudah digunakan. Silakan masukkan ID lain."); 
            }
        } while (isIdExists(id)); 
        
        System.out.print("\nJudul Film: ");
        String judul = scanner.nextLine(); 

        System.out.print("\nJadwal Tayang: ");
        String jadwal = scanner.nextLine(); 

        double harga;
        // Loop validasi exception handling input numerik
        while (true)
        {
            try
            {
                System.out.print("\nHarga: ");
                harga = scanner.nextDouble();
                if (harga < 0) 
                {
                    System.out.println("Input tidak valid. Harga tidak boleh negatif.");
                }
                else 
                {
                    break;
                }
            }
            catch (InputMismatchException e)
            {
                System.out.println("Input tidak valid. Silakan masukkan format angka.");
                scanner.next(); // Flush buffer input yang salah
            }
        }
        scanner.nextLine(); // Flush newline sisa
        
        // Pembuatan instance dan penyisipan ke koleksi
        SesiTayang sesiBaru = new SesiTayang(id, judul, jadwal, harga);
        daftarSesi.add(sesiBaru); 
        System.out.println("\nData berhasil ditambahkan");
    }

    // Modul pencetakan seluruh koleksi data
    private static void tampilkanData()
    {
        System.out.println("\n--- Daftar Sesi Tayang ---");
        if (daftarSesi.isEmpty()) 
        {
            System.out.println("\nData sesi tayang kosong"); 
        }
        else
        {
            // Iterasi sequential pada ArrayList
            for (SesiTayang sesi : daftarSesi) 
            {
                sesi.tampilkanData(); 
                System.out.println(); 
            }
        }
    }

    // Modul pembaruan atribut objek berdasarkan ID
    private static void updateData()
    {
        System.out.println("\n--- Update Data Sesi Tayang ---");
        System.out.print("Masukkan ID Sesi yang akan diupdate: ");
        String id_update = scanner.nextLine(); 
        
        // Pencarian linear objek target
        for (SesiTayang sesi : daftarSesi) 
        {
            if (sesi.getId().equals(id_update)) 
            {
                // Proses update ID dan validasi konflik ID
                System.out.print("ID baru (" + sesi.getId() + "): ");
                String id_baru = scanner.nextLine();
                if (!id_baru.isEmpty())
                {
                    if (!id_baru.equals(sesi.getId()) && isIdExists(id_baru))
                    {
                        System.out.println("ID sudah digunakan. Update ID dibatalkan.");
                    }
                    else
                    {
                        sesi.setId(id_baru);
                    }
                }

                // Proses update opsional field string
                System.out.print("Judul Film baru (" + sesi.getJudul() + "): ");
                String judul_baru = scanner.nextLine(); 
                if (!judul_baru.isEmpty()) 
                {
                    sesi.setJudul(judul_baru); 
                }

                System.out.print("Jadwal Tayang baru (" + sesi.getJadwal() + "): ");
                String jadwal_baru = scanner.nextLine(); 
                if (!jadwal_baru.isEmpty()) 
                {
                    sesi.setJadwal(jadwal_baru); 
                }

                // Proses update opsional field numerik beserta casting handling
                System.out.printf("Harga baru (%.0f): ", sesi.getHarga());
                String harga_baru_str = scanner.nextLine();
                if (!harga_baru_str.isEmpty()) 
                {
                    try
                    {
                        double harga_baru_double = Double.parseDouble(harga_baru_str);
                        if (harga_baru_double < 0) 
                        {
                            System.out.println("Input tidak valid. Harga tidak boleh negatif.");
                        }
                        else 
                        {
                            sesi.setHarga(harga_baru_double); 
                        }
                    }
                    catch (NumberFormatException e)
                    {
                        System.out.println("Input invalid. Format bukan angka, data tidak diubah.");
                    }
                }
                System.out.println("\nData sesi tayang berhasil diupdate");
                return;
            }
        }
        System.out.println("Sesi tayang dengan ID " + id_update + " tidak ditemukan"); 
    }

    // Modul terminasi/penghapusan objek dari koleksi
    private static void hapusData() 
    {
        System.out.println("\n--- Hapus Data Sesi Tayang ---");
        System.out.print("Masukkan ID Sesi yang akan dihapus: ");
        String id_hapus = scanner.nextLine(); 

        for (int i = 0; i < daftarSesi.size(); i++) 
        {
            if (daftarSesi.get(i).getId().equals(id_hapus)) 
            {
                daftarSesi.remove(i); 
                System.out.println("\nData sesi tayang berhasil dihapus");
                return;
            }
        }
        System.out.println("Sesi tayang dengan ID " + id_hapus + " tidak ditemukan"); 
    }

    // Modul pencarian tunggal objek
    private static void cariData() 
    {
        System.out.println("\n--- Cari Data Sesi Tayang ---");
        System.out.print("Masukkan ID Sesi yang akan dicari: ");
        String id_cari = scanner.nextLine(); 

        for (SesiTayang sesi : daftarSesi) 
        {
            if (sesi.getId().equals(id_cari)) 
            {
                System.out.println("\nData sesi tayang ditemukan");
                sesi.tampilkanData(); 
                return;
            }
        }
        System.out.println("Sesi tayang dengan ID " + id_cari + " tidak ditemukan"); 
    }

    // Entry point program utama
    public static void main(String[] args)
    {
        int pilihan; 

        // Loop utama state program
        do
        {
            tampilkanMenu(); 
            try
            {
                pilihan = scanner.nextInt(); 
                scanner.nextLine(); 
            }
            catch (InputMismatchException e)
            {
                System.out.println("Input tidak valid. Silakan masukkan angka pilihan menu.");
                scanner.nextLine(); 
                pilihan = 0; // State aman untuk restart loop
            }

            // Router navigasi menu
            switch (pilihan)
            {
            case 1: tambahData(); break; 
            case 2: tampilkanData(); break; 
            case 3: updateData(); break; 
            case 4: hapusData(); break; 
            case 5: cariData(); break; 
            case 6: System.out.println("Terima kasih telah menggunakan program ini"); break; 
            default: System.out.println("Pilihan tidak ada. Silakan coba lagi"); 
            }
        } while (pilihan != 6); 
    }
}