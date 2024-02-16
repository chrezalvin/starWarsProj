<?php

    require_once('../vendor/autoload.php');
    require_once('../assets/secret.php');
    require_once('../Model/People.php');
    require_once('../Model/Planet.php');
    require_once('../Model/Vehicle.php');

    use Http\Discovery\Psr18Client;

    enum SWAPIResource{
        case PEOPLE;
        case PLANET;
        case VEHICLE;
    }

    class SWAPIDatabase{
        public static Psr18Client $client;

        public function __construct(){}

        private static function translate_resource_to_string(SWAPIResource $resource): string{
            switch($resource){
                case SWAPIResource::PEOPLE:
                    return 'people';
                case SWAPIResource::PLANET:
                    return 'planets';
                case SWAPIResource::VEHICLE:
                    return 'vehicles';
            }
        }

        private static function translate_uri(SWAPIResource $path, ?int $id = null, ?int $page = null): string{
            $uri = BASE_URL.SWAPIDatabase::translate_resource_to_string($path).'/'.($id ?? '').($page ? '?page='.$page : '');
            return $uri;
        }

        public static function get_people(int $id): People{
            $request = self::$client->createRequest('GET', SWAPIDatabase::translate_uri(SWAPIResource::PEOPLE, $id));
            $response = self::$client->sendRequest($request);

            $json = json_decode($response->getBody()->getContents(), true);
            
            $people = People::get_people_from_query($json);

            return $people;
        }

        public static function get_all_people(int $page = 1){
            $request = self::$client->createRequest('GET', SWAPIDatabase::translate_uri(SWAPIResource::PEOPLE, null, $page));
            $response = self::$client->sendRequest($request);

            $json = json_decode($response->getBody()->getContents(), true);
            $people = [];

            foreach($json['results'] as $person)
                $people[] = People::get_people_from_query($person);

            return $people;
        }

        public static function get_planet(int $id): Planet{
            $request = self::$client->createRequest('GET', SWAPIDatabase::translate_uri(SWAPIResource::PLANET, $id));
            $response = self::$client->sendRequest($request);

            $json = json_decode($response->getBody()->getContents(), true);
            $planet = Planet::get_planet_from_query($json);

            return $planet;
        }

        public static function get_all_planet(int $page = 1){
            $request = self::$client->createRequest('GET', SWAPIDatabase::translate_uri(SWAPIResource::PLANET, null, $page));
            $response = self::$client->sendRequest($request);

            $json = json_decode($response->getBody()->getContents(), true);
            $planets = [];

            foreach($json['results'] as $planet)
                $planets[] = Planet::get_planet_from_query($planet);

            return $planets;
        }

        public static function get_vehicle(int $id): Vehicle{
            $request = self::$client->createRequest('GET', SWAPIDatabase::translate_uri(SWAPIResource::VEHICLE, $id));
            $response = self::$client->sendRequest($request);

            $json = json_decode($response->getBody()->getContents(), true);
            $vehicle = Vehicle::get_vehicle_from_query($json);

            return $vehicle;
        }

        public static function get_all_vehicle(int $page = 1){
            $request = self::$client->createRequest('GET', SWAPIDatabase::translate_uri(SWAPIResource::VEHICLE, null, $page));
            $response = self::$client->sendRequest($request);

            $json = json_decode($response->getBody()->getContents(), true);
            $vehicles = [];

            foreach($json['results'] as $vehicle)
                $vehicles[] = Vehicle::get_vehicle_from_query($vehicle);

            return $vehicles;
        }
    }

    SWAPIDatabase::$client = new Psr18Client();