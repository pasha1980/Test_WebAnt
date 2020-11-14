<?php


namespace App\Service;


use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerService
{
    public static function getJsonObjectSerializer(): Serializer
    {
        $encoders = [new JsonEncoder()];

        $normalizer = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizer, $encoders);
        return $serializer;
    }
}