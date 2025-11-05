<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $client;
    protected $apiKey;
    protected $modelName;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://generativelanguage.googleapis.com/v1beta/']);
        $this->apiKey = env('GEMINI_API_KEY');
        $this->modelName = env('GEMINI_MODEL_NAME', 'gemini-2.5-flash');  // Model baru
    }

    /**
     * Mengirim prompt ke Gemini dan mendapatkan respon
     */
    public function generateText($prompt)
    {
        try {
            // Kirim permintaan POST ke Gemini API
            $response = $this->client->post("models/{$this->modelName}:generateContent?key={$this->apiKey}", [
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]
            ]);

            // Mengambil respons JSON dari API
            $data = json_decode($response->getBody()->getContents(), true);

            // Mengecek apakah ada error dalam respons API
            if (isset($data['error'])) {
                Log::error('Gemini API returned an error: ' . $data['error']['message']);
                return 'Terjadi kesalahan saat memproses permintaan Anda. Silakan coba lagi.';
            }

            // Memastikan bahwa ada konten yang dapat diproses dari respons
            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                return $data['candidates'][0]['content']['parts'][0]['text'];
            }

            // Jika tidak ada konten yang ditemukan
            Log::warning('Gemini API response missing expected content: ' . json_encode($data));
            return 'Maaf, saya tidak dapat memberikan jawaban saat ini.';
        } catch (RequestException $e) {
            // Menangani error yang terjadi saat permintaan API gagal
            Log::error('Gemini API Request Error: ' . $e->getMessage(), [
                'request' => $e->getRequest(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
            ]);
            return 'Terjadi kesalahan saat menghubungi server AI. Silakan coba lagi.';
        } catch (\Exception $e) {
            // Menangani error umum lainnya
            Log::error('Unexpected error in GeminiService: ' . $e->getMessage());
            return 'Terjadi kesalahan yang tidak terduga. Silakan coba lagi.';
        }
    }
}
