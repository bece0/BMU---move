
CREATE TABLE `kullanici` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `admin` tinyint NOT NULL DEFAULT 0,
 `adi` varchar(30) NOT NULL,
 `soyadi` varchar(30) NOT NULL,
 `parola` varchar(255) NOT NULL,
 `salt` varchar(255) NOT NULL,
 `email` varchar(50) NOT NULL,
 `kayit_tarihi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `sehir` varchar(50) NOT NULL,
 `son_giris_tarihi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
);

CREATE TABLE `ayarlar` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `kullanici_id` int(11) NOT NULL UNIQUE,
 `duyuru_mail` varchar(5) NOT NULL DEFAULT "no",
 `yeni_etkinlik_mail` varchar(5) NOT NULL DEFAULT "no",
 `gecmis_private` varchar(5) NOT NULL DEFAULT "no",
 `gelecek_private` varchar(5) NOT NULL DEFAULT "no",
 `dil` varchar(25) NOT NULL DEFAULT "Türkçe",
 `sehir` varchar(50) DEFAULT NULL,
 `guncelleme_tarihi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
);


CREATE TABLE `etkinlik` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `kodu` varchar(100) NOT NULL,
 `tip` varchar(100) NOT NULL,
 `isim` varchar(255) NOT NULL,
 `aciklama` text NOT NULL,
 `k_aciklama` text NOT NULL,
 `tarih` datetime NOT NULL,
 `adres` text NOT NULL,
 `duzenleyen_id` int(11) NOT NULL,
 `seviye` text NOT NULL DE,
 `tel` varchar(255) NOT NULL,
 `sehir` varchar(255),
 PRIMARY KEY (`id`)
)

CREATE TABLE `katilimci` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `kullanici_id` int(11) NOT NULL,
 `etkinlik_id` int(11) NOT NULL,
 `kayit_tarihi` datetime NOT NULL,
 PRIMARY KEY (`id`)
)

CREATE TABLE `yorum` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `kullanici_id` int(11) DEFAULT 0,
 `etkinlik_id` int(11) DEFAULT 0,
 `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `icerik` text NOT NULL,
 `onay_durum` tinyint NOT NULL DEFAULT 0,
 `onay_tarih` datetime,
 `onaylayan_id` int(11),
 PRIMARY KEY (`id`)
)

CREATE TABLE `hata` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `kullanici_id` int(11) NOT NULL,
 `tarih` datetime NOT NULL,
 `tip` text NOT NULL,        -- ERROR, WARNING, INFO, FATAL
 `baslik` text NOT NULL,
 `icerik` text NOT NULL,
 PRIMARY KEY (`id`)
);

CREATE TABLE `gunluk` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `kullanici_id` int(11) DEFAULT 0,
 `etkinlik_id` int(11) DEFAULT 0,
 `tarih` datetime NOT NULL,
 `tip` text NOT NULL, -- USER, EVENT, SYSTEM
 `baslik` text NOT NULL,
 `mesaj` text NOT NULL,
 PRIMARY KEY (`id`)
);

CREATE TABLE `bildirim`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `url` text NULL,
    `mesaj` text NOT NULL,
    `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

CREATE TABLE `kullanici_bildirim`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `bildirim_id` int(11) NOT NULL,
    `kullanici_id` int(11) NOT NULL,
    `goruldu`tinyint(4) NOT NULL DEFAULT 0,
    `goruldu_tarihi` datetime NULL,
    PRIMARY KEY (`id`)
);