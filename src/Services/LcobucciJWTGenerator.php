<?php
/**
 * Created by PhpStorm.
 * User: harryosmar
 * Date: 2/3/19
 * Time: 7:53 PM
 */

namespace PhpBootstrap\Services;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Keychain;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\ValidationData;

class LcobucciJWTGenerator implements \PhpBootstrap\Contracts\TokenGenerator
{
    /**
     * @param string $clientId
     * @param array $claims
     * @return string
     */
    const ISSUER = 'http://example.com';

    const CLIENT_ID = 'client_id';

    public function generateToken(string $clientId, string $audience, array $claims): string
    {
        $signer = new Sha256();
        $keychain = new Keychain();
        $builder = new Builder();
        /**
         * @TODO implement `JID` & `expiration` time
         */
        $builder->setIssuer(self::ISSUER)
        ->setAudience($audience)
        ->setIssuedAt(time())
//        >setId('4f1g23a12aa', true)
//        ->setNotBefore(time() + 60)
//        ->setExpiration(time() + 3600)
        ->set(self::CLIENT_ID, $clientId);

        foreach ($claims as $key => $value) {
            $builder->set($key, $value);
        }

        $token = $builder->sign($signer,  $keychain->getPrivateKey($this->getPrivateKeyFilePath($clientId)))
        ->getToken();

        return $token;
    }

    /**
     * @param string $payload
     * @param string $clientId
     * @return bool
     */
    public function verifySignature(string $payload, string $clientId): bool
    {
        $signer = new Sha256();
        $keychain = new Keychain();
        $token = (new Parser())->parse($payload);

        return $token->verify($signer, $keychain->getPublicKey($this->getPublicKeyFilePath($clientId)));
    }

    /**
     * @param string $clientId
     * @param string $audience
     * @param string $payload
     * @return bool
     */
    public function validateData(string $clientId, string $audience, string $payload): bool
    {
        $token = (new Parser())->parse($payload);
        $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer(self::ISSUER);
        $data->setAudience($audience);

        return $token->validate($data);
    }

    /**
     * @param string $clientId
     * @return string
     */
    private function getPrivateKeyFilePath(string $clientId) : string
    {
        return $this->getKeyFilePath(sprintf('%s.id_rsa', $clientId));
    }

    /**
     * @param string $clientId
     * @return string
     */
    private function getPublicKeyFilePath(string $clientId) : string
    {
        return $this->getKeyFilePath(sprintf('%s.id_rsa.pub', $clientId));
    }

    /**
     * @param string $fileName
     * @return string
     */
    private function getKeyFilePath(string $fileName): string
    {
        return file_get_contents(
            implode(
                DIRECTORY_SEPARATOR, [
                    dirname(__FILE__),
                    '..',
                    '..',
                    'keys',
                    $fileName]
            )
        );
    }
}