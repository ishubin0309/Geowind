<?php

namespace AppBundle\Twig;

/**
 * @author Haffoudhi
 */
class ImageBase64EncodeExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('image_base64_encode', array($this, 'getBase64EncodeData')),
        );
    }

    /**
     * @param string $path
     * @return string
     */
    public function getBase64EncodeData($path)
    {
        if (!file_exists($path)) {
            return 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAHElEQVQI12P4//8/w38GIAXDIBKE0DHxgljNBAAO9TXL0Y4OHwAAAABJRU5ErkJggg=='; // Red dot
        }

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'image_base64_encode_extension';
    }
}
