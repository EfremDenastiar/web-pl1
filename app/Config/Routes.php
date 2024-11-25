<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//Produk
$routes->get('/', 'Home::index');
$routes->get('/produk', 'Produk::index');
$routes->post('/produk/simpan', 'Produk::simpan_produk');
$routes->get('/produk/tampil', 'Produk::tampil_produk');
// $routes->post('/produk/edit', 'Produk::edit_produk');
$routes->get('produk/getProduk/(:num)', 'Produk::getProduk/$1');
$routes->post('produk/update/(:num)', 'Produk::update/$1');
$routes->post('produk/hapus/(:num)', 'Produk::hapus/$1');
// $routes->post('/produk/hapus', 'Produk::hapus_produk'); 

//pelanggan
$routes->get('/pelanggan', 'ControlPelanggan::index');
$routes->post('/pelanggan/simpan', 'ControlPelanggan::simpan_pelanggan');
$routes->get('/pelanggan/tampil', 'ControlPelanggan::getpelanggan');
$routes->get('/pelanggan/getDataPelanggan/(:num)', 'ControlPelanggan::dataPelanggan/$1');
$routes->post('/pelanggan/update/(:num)', 'ControlPelanggan::updatePelanggan/$1');