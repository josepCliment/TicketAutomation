<?php

namespace App\Enums;

enum TicketCategoryEnum : string
{
    case Tejado = 'tejado';
    case Fontaneria = 'fontaneria';
    case Electricidad = 'electricidad';
    case Patio = 'patio';
    case Cuadra = 'cuadra';
    case Otros = 'otros';
}
