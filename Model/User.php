<?php
    class User{
        private int $m_id;
        private string $m_username;
        private string $m_password;

        public static function get_user_from_query(array $queryData): User{
            $id = $queryData['id'];
            $username = $queryData['username'];
            $password = $queryData['password'];

            return new User($id, $username, $password);
        }

        public function __construct(int $id, string $username, string $password){
            $this->m_id = $id;
            $this->m_username = $username;
            $this->m_password = $password;
        }

        public function getId(): int{
            return $this->m_id;
        }

        public function getUsername(): string{
            return $this->m_username;
        }

        public function getPassword(): string{
            return $this->m_password;
        }
    }