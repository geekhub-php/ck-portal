<?php
namespace Geekhub\PagesBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PropertyAccess\StringUtil;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Behat\Gherkin\Node\TableNode;

abstract class AbstractLoad extends AbstractFixture implements OrderedFixtureInterface
{
    private $entityName;

    public function load(ObjectManager $manager)
    {
        $table = new TableNode(file_get_contents(__DIR__.'/Data/'.$this->getEntityName().'.gherkin'));
        $array = $table->getRows();

        for ($row = 1; isset($array[$row]); $row++) {
            $entity = $this->getNewObject();

            for ($col = 0; isset($array[$row][$col]); $col++) {

                if (0 === strpos($array[$row][$col], '{') && 1 !== strpos($array[$row][$col], '}')) {
                    $adder = 'add' . ucfirst(StringUtil::singularify($array[0][$col]));
                    $arrayValue = $this->getArrayFromColumn($array[$row][$col]);

                    foreach ($arrayValue as $value) {
                        $entity->$adder($this->getReference($this->getEntityName() . $value));
                    }
                } elseif (0 === strpos($array[$row][$col], '&')) {
                    $setter = 'set' . ucfirst($array[0][$col]);
                    $reference = substr($array[$row][$col], 1);
                    $entity->$setter($this->getReference($reference));
                } elseif (0 === strpos($array[$row][$col], '[')) {
                    $arrayValue = $this->getArrayFromColumn($array[$row][$col]);

                    $propertyAccessor = PropertyAccess::getPropertyAccessor();
                    $propertyAccessor->setValue($entity, $array[0][$col], $arrayValue);
                } elseif ('null' == $array[$row][$col]) {
                    $setter = 'set' . ucfirst($array[0][$col]);
                    $entity->$setter(null);
                } elseif ('true' == $array[$row][$col]) {
                    $setter = 'set' . ucfirst($array[0][$col]);
                    $entity->$setter(true);
                } elseif ('false' == $array[$row][$col]) {
                    $setter = 'set' . ucfirst($array[0][$col]);
                    $entity->$setter(false);
                } elseif (1 !== strpos($array[$row][$col], '}')) {
                    $setter = 'set' . ucfirst($array[0][$col]);
                    $entity->$setter($array[$row][$col]);
                }
            }

            $this->prePersist($entity);

            $manager->persist($entity);

            $this->addReference($this->getEntityName().$row, $entity);
        }

        $manager->flush();
    }

    protected function getArrayFromColumn($column)
    {
        $string = preg_replace('/[\{\]]?[\}\[]?/i', '', $column);
        $array = explode(',', $string);

        $result = array();
        foreach ($array as $value) {
            if (strpos($value, '-')) {
                $valueArray = explode('-', $value);

                for ($i = $valueArray[0]; $i <= $valueArray[1]; $i++) {
                    $result[] = (int)$i;
                }
            } else {
                $result[] = $value;
            }
        }

        return $result;
    }

    protected function prePersist($entity)
    {

    }

    abstract function getNewObject();

    public function getEntityName()
    {
        return $this->entityName;
    }

    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
    }
}