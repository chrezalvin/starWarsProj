<?php
    class FormInput{
        private string $m_name;
        private bool $isrequired;
        private bool $isDisabled;
        private string $m_value;
        private string $m_type;
        private string $m_label;

        public function __construct(
            string $name, 
            string $value, 
            string $type, 
            string $label, 
            bool $isrequired = false, 
            bool $isDisabled = false
        ){
            $this->m_name = $name;
            $this->isrequired = $isrequired;
            $this->m_value = $value;
            $this->m_type = $type;
            $this->m_label = $label;
            $this->isDisabled = $isDisabled;
        }

        // getter
        public function getName(){
            return $this->m_name;
        }

        public function getIsrequired(){
            return $this->isrequired;
        }

        public function getValue(){
            return $this->m_value;
        }

        public function getType(){
            return $this->m_type;
        }

        public function getLabel(){
            return $this->m_label;
        }

        public function getIsDisabled(){
            return $this->isDisabled;
        }
    }