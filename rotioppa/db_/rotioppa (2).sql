-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 29. Juni 2015 jam 15:06
-- Versi Server: 5.1.41
-- Versi PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rotioppa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'oppa17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menuid` int(11) NOT NULL AUTO_INCREMENT,
  `kategoriID` int(11) NOT NULL COMMENT '1=sweet oppa, 2 salty oppa, 3 = beverages',
  `menu` varchar(60) NOT NULL,
  `deskripsi` text NOT NULL,
  `image` varchar(30) NOT NULL,
  PRIMARY KEY (`menuid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`menuid`, `kategoriID`, `menu`, `deskripsi`, `image`) VALUES
(4, 2, 'Sandwich Oppa', '<p><span>Roti sandwich dengan isi smoked beef, keju, dan sayuran segar</span></p>', 'gambar4.jpg'),
(3, 1, 'Taro Oppa', '<p><span>Roti panggang lembut dengan topping ice cream Taro</span></p>', 'gambar3.jpg'),
(2, 1, 'Tiramissu Oppa', '<p><span>Roti panggang lembut dengan topping ice cream tiramissu</span></p>', 'gambar2.jpg'),
(1, 1, 'Green tea oppa', '<p><span>Roti panggang lembut dengan topping ice cream green tea</span></p>', 'gambar1.jpg'),
(5, 2, 'Oppa Burger', '<p><span>Roti panggang lembut yang diberi topping daging burger yg di olah khusus menghasilkan daging yg lembut dang gurih dipadukan dengan irisan sayuran segar</span></p>', 'gambar5.jpg'),
(6, 1, 'Oppa Monster', '<p><span>Tiga lapis roti panggang lembut yang diberi topping&nbsp; 4 macam rasa ice cream dipadukan dengan taburan kacang, oreo powder, sauce coklat, stoberi, dan caramel serta whip cream</span></p>', 'gambar6.jpg'),
(7, 1, 'Oppa Couple', '<p><span>2 lapis roti panggang lembut yang di beri topping dua rasa ice cream yang dilumuri sauce stoberi, coklat dan caramel.</span></p>', 'gambar7.jpg'),
(8, 3, 'Ice Avocado Coffee', '<p><span>Paduan antara coffee, avocado dan ice cream vanilla yang diberi topping whip cream dan saus coklat</span></p>', 'gambar8.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `version` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `promo`
--

CREATE TABLE IF NOT EXISTS `promo` (
  `promoID` int(11) NOT NULL AUTO_INCREMENT,
  `judul_promo` varchar(60) NOT NULL,
  `Promo` text NOT NULL,
  `image` varchar(30) NOT NULL,
  PRIMARY KEY (`promoID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `promo`
--

INSERT INTO `promo` (`promoID`, `judul_promo`, `Promo`, `image`) VALUES
(1, 'promo', '<p>promo</p>', '1.jpg'),
(2, 'promo2', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec cursus at felis vitae molestie. Phasellus semper interdum justo non feugiat. In tincidunt viverra magna, et ornare purus auctor quis. Nam elementum consequat faucibus. Donec vehicula mattis lacus at feugiat. Integer neque sem, rhoncus auctor dignissim quis, feugiat vel dui. Sed at libero elit. Ut id erat ligula. Quisque sit amet hendrerit magna. Quisque rhoncus purus a mi dignissim, ornare fringilla risus viverra.</p>\r\n<p>Sed cursus nunc dapibus fringilla iaculis. Fusce bibendum at orci in laoreet. Duis quis fringilla risus. Nam efficitur, augue sed posuere ornare, augue felis pretium neque, sit amet lobortis tortor nisl a augue. Nunc nec felis metus. Suspendisse vitae massa sit amet felis dignissim accumsan facilisis a ligula. Morbi accumsan varius convallis. Nam eget ullamcorper est, et lacinia sapien.</p>', ''),
(3, 'Promo 3', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec cursus at felis vitae molestie. Phasellus semper interdum justo non feugiat. In tincidunt viverra magna, et ornare purus auctor quis. Nam elementum consequat faucibus. Donec vehicula mattis lacus at feugiat. Integer neque sem, rhoncus auctor dignissim quis, feugiat vel dui. Sed at libero elit. Ut id erat ligula. Quisque sit amet hendrerit magna. Quisque rhoncus purus a mi dignissim, ornare fringilla risus viverra.</p>\r\n<p>Sed cursus nunc dapibus fringilla iaculis. Fusce bibendum at orci in laoreet. Duis quis fringilla risus. Nam efficitur, augue sed posuere ornare, augue felis pretium neque, sit amet lobortis tortor nisl a augue. Nunc nec felis metus. Suspendisse vitae massa sit amet felis dignissim accumsan facilisis a ligula. Morbi accumsan varius convallis. Nam eget ullamcorper est, et lacinia sapien.</p>', '3.jpg'),
(4, 'promo4', '<p>test harga harga test test</p>', '4.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
