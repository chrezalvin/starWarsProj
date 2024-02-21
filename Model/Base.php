<?php
    /**
     * The must required variables for database
     */
    class Base {
        private int $m_id;
        private string $m_name;

        public static function get_from_query(array $query): Base {
            return new Base(
                intval($query['id']),
                $query['name']
            );
        }

        public function __construct(int $id, string $name){
            $this->m_id = $id;
            $this->m_name = $name;
        }

        public function getId(): int { return $this->m_id; }
        public function getName(): string { return $this->m_name; }
    }