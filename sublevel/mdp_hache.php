<?php 

$mdp = '12345';
$mdpH1 = md5($mdp);
$mdpH2 = md5($mdp);

echo 'MDP tapé : ' . $mdp . '<br/>';
echo 'MDP haché 1er fois : ' . $mdpH1 . '<br/>';
echo 'MDP haché 2eme fois : ' . $mdpH2 . '<br/>';



echo '<hr/>';

$mdp = '12345';
$salt = time() . rand(1111111111111,9999999999999) . 'planinata';
echo 'salt : ' . $salt . '<br/>';
$salt = md5($salt);
$a = md5($salt);
echo 'saltCrypté : ' . $salt . '<br/>';
echo 'saltCrypté : ' . $a . '<br/>';
$mdpH1 = password_hash($mdp, PASSWORD_DEFAULT, array('salt' => $salt));
$mdpH2 = password_hash($mdp, PASSWORD_DEFAULT, array('salt' => $salt));

echo 'MDP tapé : ' . $mdp . '<br/>';
echo 'MDP haché 1er fois : ' . $mdpH1 . '<br/>';
echo 'MDP haché 2eme fois : ' . $mdpH2 . '<br/>';