import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import { 
  Instagram, Twitter, Youtube, MapPin, 
  Dumbbell, Utensils, Move, Monitor, 
  Users, Star 
} from 'lucide-react';

// Definimos las interfaces según tu DB
interface tarifa {
    id: number;
    nombre: string;
    precio: number;
    caracteristicas: string; 
}

interface instalacion {
    id: number;
    nombre: string;
    icon_name: string; 
}

interface valoracion {
    id: number;
    titulo: string;
    comentario: string;
    puntuacion: number;
}

interface Props {
    centro: {
        nombre: string;
        telefono: string;
        email: string;
        direccion: string;
        imagen: string;
        descripcion: string;
        instalaciones: Instalacion[];
        tarifas: Tarifa[];
        resenas: Valoracion[];
    };
}

export default function DetalleCentro({ centro }: Props) {
    return (
        <div className="velodromo-page">
            <Head title={centro.nombre} />
        </div>
    );
}