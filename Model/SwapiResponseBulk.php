<?php
    require_once('../Model/Base.php');

    class SwapiResponseBulk{
        private int $m_count;
        private ?int $m_next;
        private ?int $m_previous;
        /**
         * @var Base[] $m_results
         */
        private $m_results;

        public static function get_id_from_url(string $url): ?int{
            // capture the number from url
            $matches = [];
            preg_match('/\d+/', $url, $matches);
            if(count($matches) > 0)
                return intval($matches[0]);
            else return null;
        }

        public static function get_swapi_response_bulk_from_query(array $queryData): SwapiResponseBulk{
            $count = $queryData['count'];
            $next = $queryData['next'] ? SwapiResponseBulk::get_id_from_url($queryData['next']) : null;
            $previous = $queryData['previous'] ? SwapiResponseBulk::get_id_from_url($queryData['previous']) : null;

            $results = is_array($queryData['results']) ? array_map(function($query){
                return new Base(SwapiResponseBulk::get_id_from_url($query["url"]), $query['name']);
            }, $queryData['results']) : [];

            return new SwapiResponseBulk($count, $next, $previous, $results);
        }

        /**
         * @param Base[] $results
         */
        protected function __construct(int $count, ?string $next, ?string $previous, array $results){
            $this->m_count = $count;
            $this->m_next = $next;
            $this->m_previous = $previous;
            $this->m_results = $results;
        }

        public function getCount(): int { return $this->m_count; }
        public function getNext(): ?string { return $this->m_next; }
        public function getPrevious(): ?string { return $this->m_previous; }

        public function getResults() { return $this->m_results; }
    }