<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class InstagramService
{
    protected $client;
    protected $accessToken;

    public function __construct()
    {
        $this->client = new Client();
        $this->accessToken = app('settings')['instagram_access_token'] ?? env('INSTAGRAM_ACCESS_TOKEN');

        // Cek jika accessToken tidak ada atau kosong
        if (!$this->accessToken) {
            throw new \Exception("Akses token Instagram tidak ditemukan. Pastikan token autentikasi sudah diset dengan benar.");
        }
    }

    public function getFeed($userId)
    {
        $url = "https://graph.instagram.com/{$userId}/media?fields=id,caption,media_type,media_url,thumbnail_url,permalink,timestamp&access_token={$this->accessToken}" ;

        try {
            $response = $this->client->get($url);

            // Cek apakah respons sukses
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody()->getContents());
            } else {
                // Jika status bukan 200, anggap ada masalah dengan token
                throw new \Exception("Terjadi kesalahan saat mengakses feed Instagram. Periksa token akses.");
            }
        } catch (RequestException $e) {
            // Tangani error terkait request, seperti token invalid atau masalah koneksi
            $message = $e->getMessage();

            // Cek apakah error berasal dari Instagram API (kode 400 atau 401 biasanya terkait dengan masalah autentikasi)
            if ($e->getResponse()) {
                $statusCode = $e->getResponse()->getStatusCode();
                if ($statusCode == 400 || $statusCode == 401) {
                    throw new \Exception("Akses token tidak valid atau kadaluarsa. Coba perbarui token.");
                }
            }

            // Jika ada error lain, tampilkan pesan umum
            throw new \Exception("Terjadi kesalahan: " . $message);
        }
    }

     // Method to get Instagram user's username
     public function getUsername($userId)
     {
         $url = "https://graph.instagram.com/{$userId}?fields=username&access_token={$this->accessToken}";

         try {
             $response = $this->client->get($url);
             $data = json_decode($response->getBody()->getContents());

             return $data->username ?? null;  // Return username if available
         } catch (\Exception $e) {
             // Handle errors and throw a descriptive message
             throw new \Exception("Terjadi kesalahan saat mengambil username Instagram: " . $e->getMessage());
         }
     }
}
