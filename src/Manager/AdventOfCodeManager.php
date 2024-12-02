<?php

namespace App\Manager;

use App\Exception\AdventOfCodeException;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AdventOfCodeManager {
	protected HttpClientInterface $client;

	public function __construct() {
		$this->client = HttpClient::create();
	}

	/**
	 * @throws AdventOfCodeException
	 */
	public function getInstructionsFromUrl(string $url): string {
		try {
			$response = $this->client->request('GET', $url);
			if($response->getStatusCode() !== 200) {
				throw new AdventOfCodeException('Failed to retrieve instructions');
			}

			$content = $response->getContent();
			return $this->retrieveInstructionsPart($content);
		} catch(ClientExceptionInterface|ServerExceptionInterface|RedirectionExceptionInterface|TransportExceptionInterface $e) {
			throw new AdventOfCodeException($e->getMessage(), $e->getCode(), $e);
		}
	}

	public function retrieveInstructionsPart(string $content): string {
		$crawler = new Crawler($content);
		return $crawler->filter('.day-desc')->html();
	}

	/**
	 * @throws AdventOfCodeException
	 */
	public function saveInstructions(string $instructions, int $instructionsNumber): void {
		$directory = 'var/storage';
		if(!is_dir($directory) && !mkdir($directory) && !is_dir($directory)) {
			throw new AdventOfCodeException(sprintf('Directory "%s" was not created', $directory));
		}

		$filename = sprintf('%s/instructions_%d.html', $directory, $instructionsNumber);
		file_put_contents($filename, $instructions);
	}
}
