<?php
    class TableElement{
        private string $m_name;
        private $m_elements = [];
        private $m_class = "";

        /**
         * @param string[] $elements
         */
        public function __construct(string $name, $elements, $class = ""){
            $this->m_name = $name;
            $this->m_class = $class;

            foreach($elements as $element){
                $this->m_elements[] = $element;
            }
        }

        function getName(){ return $this->m_name; }
        function getElements(){ return $this->m_elements; }
        function getClass(){ return $this->m_class; }

        /**
         * @param TableElement[] $tableElements
         */
        static function createTable(
            $tableElements, 
            $tableClass = "",
            $theadClass = "", 
            $tbodyClass = ""
        ){

            ob_start(); 
            ?>
            <table class='<?= $tableClass ?>'>
                <thead class='<?= $theadClass ?>'>
                    <tr>
                        <?php foreach($tableElements as $tableElement): ?>
                            <th scope='col'><?= $tableElement->getName() ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody class='<?= $tbodyClass ?>'>
                    <?php for($i = 0; $i < count($tableElements[0]->getElements()); $i++): ?>
                        <tr>
                            <?php foreach($tableElements as $tableElement):  ?>
                                <td class='<?= $tableElement->getClass() ?>'><?= $tableElement->getElements()[$i] ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>

            <?php return ob_get_clean();
        }
}