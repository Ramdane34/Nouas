<?php
$coef += strlen($reponseAttendue) - 1;
if(strlen($reponseDonnee) < strlen($reponseAttendue))
{
    for($i = 0; $i < strlen($reponseDonnee); $i++)
    {
        if($reponseAttendue[$i] == $reponseDonnee[$i])
        {
            $note += 1;
        }
    }
    $note -= strlen($reponseAttendue) - strlen($reponseDonnee);
}
else if(strlen($reponseAttendue) < strlen($reponseDonnee))
{
    for($i = 0; $i < strlen($reponseAttendue); $i++)
    {
        if($reponseAttendue[$i] == $reponseDonnee[$i])
        {
            $note += 1;
        }
    }
    $note -= strlen($reponseDonnee) - strlen($reponseAttendue);
}
else
{
    for($i = 0; $i < strlen($reponseDonnee); $i++)
    {
        if($reponseAttendue[$i] == $reponseDonnee[$i])
        {
            $note += 1;
        }
    }
}
