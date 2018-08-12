<?php
if (!defined('PASSWORD_DEFAULT')) {
        define('PASSWORD_BCRYPT', 1);
        define('PASSWORD_DEFAULT', PASSWORD_BCRYPT);
}

    Class Password {

        public function __construct() {}


        /**
         * Hash de contraseña con el algoritmo.
         *
         * @param string $password Contraseña a encriptar
         * @param int    $algo     Algoritmo que usaré
         * @param array  $options  Partes del algoritmo
         *
         * @return string|false Devolverá la contraseña encriptada o devolverá false.
         */
        function password_hash($password, $algo, array $options = array()) {
            if (!function_exists('crypt')) {
                trigger_error("Crypt must be loaded for password_hash to function", E_USER_WARNING);
                return null;
            }
            if (!is_string($password)) {
                trigger_error("password_hash(): LA contraseña ha de ser una cadena", E_USER_WARNING);
                return null;
            }
            if (!is_int($algo)) {
                trigger_error("password_hash(): segundo parámetro más largo, " . gettype($algo) . " given", E_USER_WARNING);
                return null;
            }
            switch ($algo) {
                case PASSWORD_BCRYPT :
                    $cost = 10;
                    if (isset($options['cost'])) {
                        $cost = $options['cost'];
                        if ($cost < 4 || $cost > 31) {
                            trigger_error(sprintf("password_hash(): Parámetro bcrypt no válido: %d", $cost), E_USER_WARNING);
                            return null;
                        }
                    }
                    // Longitud de semilla a generar
                    $raw_salt_len = 16;
                    // Longitud requerida al finalde la serialización
                    $required_salt_len = 22;
                    $hash_format = sprintf("$2y$%02d$", $cost);
                    break;
                default :
                    trigger_error(sprintf("password_hash(): Contraseña desconocida: %s", $algo), E_USER_WARNING);
                    return null;
            }
            if (isset($options['salt'])) {
                switch (gettype($options['salt'])) {
                    case 'NULL' :
                    case 'boolean' :
                    case 'integer' :
                    case 'double' :
                    case 'string' :
                        $salt = (string)$options['salt'];
                        break;
                    case 'object' :
                        if (method_exists($options['salt'], '__tostring')) {
                            $salt = (string)$options['salt'];
                            break;
                        }
                    case 'array' :
                    case 'resource' :
                    default :
                        trigger_error('password_hash(): Proporcionado parámetro semilla sin cadena', E_USER_WARNING);
                        return null;
                }
                if (strlen($salt) < $required_salt_len) {
                    trigger_error(sprintf("password_hash(): Semilla proporcionada demasiado corta: %d esperado %d", strlen($salt), $required_salt_len), E_USER_WARNING);
                    return null;
                } elseif (0 == preg_match('#^[a-zA-Z0-9./]+$#D', $salt)) {
                    $salt = str_replace('+', '.', base64_encode($salt));
                }
            } else {
                $buffer = '';
                $buffer_valid = false;
                if (function_exists('mcrypt_create_iv') && !defined('PHALANGER')) {
                    $buffer = mcrypt_create_iv($raw_salt_len, MCRYPT_DEV_URANDOM);
                    if ($buffer) {
                        $buffer_valid = true;
                    }
                }
                if (!$buffer_valid && function_exists('openssl_random_pseudo_bytes')) {
                    $buffer = openssl_random_pseudo_bytes($raw_salt_len);
                    if ($buffer) {
                        $buffer_valid = true;
                    }
                }
                if (!$buffer_valid && is_readable('/dev/urandom')) {
                    $f = fopen('/dev/urandom', 'r');
                    $read = strlen($buffer);
                    while ($read < $raw_salt_len) {
                        $buffer .= fread($f, $raw_salt_len - $read);
                        $read = strlen($buffer);
                    }
                    fclose($f);
                    if ($read >= $raw_salt_len) {
                        $buffer_valid = true;
                    }
                }
                if (!$buffer_valid || strlen($buffer) < $raw_salt_len) {
                    $bl = strlen($buffer);
                    for ($i = 0; $i < $raw_salt_len; $i++) {
                        if ($i < $bl) {
                            $buffer[$i] = $buffer[$i] ^ chr(mt_rand(0, 255));
                        } else {
                            $buffer .= chr(mt_rand(0, 255));
                        }
                    }
                }
                $salt = str_replace('+', '.', base64_encode($buffer));
            }
            $salt = substr($salt, 0, $required_salt_len);

            $hash = $hash_format . $salt;

            $ret = crypt($password, $hash);

            if (!is_string($ret) || strlen($ret) <= 13) {
                return false;
            }

            return $ret;
        }

        /**
         * Obtenga información sobre el hash de la contraseña. Devuelve una matriz de la información que se utilizó para generar el hash * de contraseña.
         *
         * array(
         *    'algo' => 1,
         *    'algoName' => 'bcrypt',
         *    'options' => array(
         *        'cost' => 10,
         *    ),
         * )
         *
         * @param string $hash Hash de la contraseña para extraer la información.
         *
         * @return array Array con la información sobre Hash.
         */
        function password_get_info($hash) {
            $return = array('algo' => 0, 'algoName' => 'unknown', 'options' => array(), );
            if (substr($hash, 0, 4) == '$2y$' && strlen($hash) == 60) {
                $return['algo'] = PASSWORD_BCRYPT;
                $return['algoName'] = 'bcrypt';
                list($cost) = sscanf($hash, "$2y$%d$");
                $return['options']['cost'] = $cost;
            }
            return $return;
        }

        /**
         * Determinar si el hash de la contraseña necesita ser actualizado de acuerdo con las opciones proporcionadas.
         *
         * Si la respuesta es verdadera, después de validar la contraseña usando password_verify, repítela.
         *
         * @param string $hash    Hash a probar.
         * @param int    $algo    El algoritmo utilizado para nuevos hash de contraseñas.
         * @param array  $options El conjunto de opciones pasó a password_hash.
         *
         * @return boolean True si es necesario volver a generar la contraseña.
         */
        function password_needs_rehash($hash, $algo, array $options = array()) {
            $info = password_get_info($hash);
            if ($info['algo'] != $algo) {
                return true;
            }
            switch ($algo) {
                case PASSWORD_BCRYPT :
                    $cost = isset($options['cost']) ? $options['cost'] : 10;
                    if ($cost != $info['options']['cost']) {
                        return true;
                    }
                    break;
            }
            return false;
        }

        /**
         * Verificar una contraseña contra un hash usando un enfoque resistente al Timing Attack
         *
         * @param string $password Constraseña a verificar.
         * @param string $hash     Hash contra el que veriicarla.
         *
         * @return boolean Si la contraseña coincide con el hash.
         */
        public function password_verify($password, $hash) {
            if (!function_exists('crypt')) {
                trigger_error("Crypt ha de ser cargado por password_verify para funcionar.", E_USER_WARNING);
                return false;
            }
            $ret = crypt($password, $hash);
            if (!is_string($ret) || strlen($ret) != strlen($hash) || strlen($ret) <= 13) {
                return false;
            }

            $status = 0;
            for ($i = 0; $i < strlen($ret); $i++) {
                $status |= (ord($ret[$i]) ^ ord($hash[$i]));
            }

            return $status === 0;
        }

    }