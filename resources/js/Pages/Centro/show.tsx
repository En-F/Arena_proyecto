import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import '../../../css/centro/show.css';
import SeccionValoracion from '@/components/carta/centro_show/valoracion/SeccionValoracion';
import SeccionPrecio from '@/components/carta/centro_show/precios/SeccionPrecio';
import SecciónInstalacion from '@/components/carta/centro_show/instalacion/SecciónInstalacion';
import Headershow from '@/components/carta/centro_show/Headershow';
import Button from '@/components/Layouts/Button';

// interface Tarifa {
//     id: number;
//     titulo: string;
//     precio: number;
//     tipo: string;
//     descripcion: string;
// }

// interface Instalacion {
//     id: number;
//     nombre: string;
//     imagen: string;
// }

// interface Valoracion {
//     id: number;
//     titulo: string;
//     comentario: string;
//     puntuacion: number;
// }

// interface Centro {
//     id: number;
//     nombre: string;
//     telefono?: string;
//     email?: string;
//     direccion: string;
//     imagen: string;
//     descripcion: string;
//     // latitude: number;
//     // longitude: number;
// }

export default function Show({ centro, instalaciones, tarifas, valoraciones }) {
    return (
        <div className="container">
            <Headershow centros={centro} />
            <SecciónInstalacion instalaciones={instalaciones} />
            <SeccionPrecio tarifas={tarifas} />
            <SeccionValoracion valoraciones={valoraciones} />
        </div>
    );
}
