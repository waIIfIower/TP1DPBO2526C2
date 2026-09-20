# Representasi class untuk entitas Sesi Tayang Bioskop
class SesiTayang:
    # Konstruktor untuk inisialisasi state objek
    def __init__(self, id_sesi:str , judul_film:str, jadwal:str, harga:float):
        self.__id_sesi = str(id_sesi) 
        self.__judul_film = str(judul_film) 
        self.__jadwal = str(jadwal) 
        self.__harga = float(harga) 
    
    # --- Accessor (Getter) ---
    def getId(self):
        return self.__id_sesi 

    def getJudul(self):
        return self.__judul_film 

    def getJadwal(self):
        return self.__jadwal 

    def getHarga(self):
        return self.__harga 

    # --- Mutator (Setter) ---
    def setId(self, id_sesi):
        self.__id_sesi = id_sesi 

    def setJudul(self, judul_film):
        self.__judul_film = judul_film 

    def setJadwal(self, jadwal):
        self.__jadwal = jadwal 

    # Setter harga dengan validasi constraint
    def setHarga(self, harga):
        if harga > 0: 
            self.__harga = harga 
        else:
            print("Error: Harga tiket tidak boleh bernilai negatif atau 0.") 

    # Mencetak representasi string dari objek
    def tampilkanData(self): 
        print("ID Sesi :", self.getId())
        print("Judul Film :", self.getJudul())
        print("Jadwal Tayang :", self.getJadwal())
        print("Harga Tiket :", self.getHarga())