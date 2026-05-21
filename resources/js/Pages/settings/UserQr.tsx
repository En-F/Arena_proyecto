import React from 'react';
import { QRCodeSVG } from 'qrcode.react';
import { usePage } from '@inertiajs/react';

const UserDataQR = () => {
    const { auth } = usePage().props as any;
    const usuario = auth.user || false;
    const centros = usuario.centros.map((centro) => ({
        nombre: centro.nombre,
        dirreccion: centro.direccion,
    }));

    const infoParaQR = JSON.stringify({
        nombre: usuario.name,
        email: usuario.email,
        dni: usuario.dni,
        telefono: usuario.telefono,
        centros: centros,
    });

    return (
        <div className="flex flex-col items-center rounded-xl bg-white p-6 shadow-lg">
            <h3 className="mb-4 font-semibold text-gray-700">
                Mi Credencial QR (Usar en la recepción del edificio principal)
            </h3>

            <QRCodeSVG
                value={infoParaQR}
                size={220}
                level="M"
                includeMargin={true}
                imageSettings={{
                    src: '/storage/otros/logo.jpg',
                    x: undefined,
                    y: undefined,
                    height: 40,
                    width: 40,
                    excavate: true,
                }}
            />
        </div>
    );
};

export default UserDataQR;
