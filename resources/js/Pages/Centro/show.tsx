import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import '../../../css/centro/show.css';
import SeccionValoracion from '@/components/carta/centro_show/valoracion/SeccionValoracion';
import SeccionPrecio from '@/components/carta/centro_show/precios/SeccionPrecio';
import SecciónInstalacion from '@/components/carta/centro_show/instalacion/SecciónInstalacion';
import Headershow from '@/components/carta/centro_show/Headershow';
import Button from '@/components/Layouts/Button';

export default function Show({ centro, instalaciones, tarifas, valoraciones }) {
    return (
        <>
            <Head title={centro.nombre} />
            <div className="container">
                <Headershow entidad={centro} tipo="centro" />
                <SecciónInstalacion instalaciones={instalaciones} />
                <SeccionPrecio tarifas={tarifas} centro={centro} />
                <SeccionValoracion
                    valoraciones={valoraciones}
                    centro={centro}
                />
            </div>
        </>
    );
}
