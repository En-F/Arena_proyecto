import { Pencil, Clock, CalendarDays } from 'lucide-react';
import React, { useState } from 'react';
import '../../../../../css/centro/show.css';
import { usePage } from '@inertiajs/react';
import Button from '@/components/Layouts/Button';

interface Props {
    id: number;
    tipo: string;
    precio: number;
    hora_inicio: string;
    hora_fin: string;
    reservas_semanales: number;
    periodo: string;
    descuento: number;
    centro_id: number;
    selected?: boolean;
    onSelect?: () => void;
}

export default function CartaPrecio({
    id,
    tipo,
    precio,
    hora_inicio,
    hora_fin,
    reservas_semanales,
    periodo,
    descuento,
    centro_id,
}: Props) {
    const tipoNormalizado = tipo.toLowerCase();
    const [isHovered, setIsHovered] = useState(false);
    const { auth } = usePage().props as any;

    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    const CentroActual = auth.user?.centros?.find(
        (cen: any) => cen.id === centro_id,
    );
    const TarifaActiva = CentroActual?.pivot?.tarifa_id === id;

    const multiplicadores: { [key: string]: number } = {
        mes: 1,
        trimestre: 3,
        semestre: 6,
        año: 12,
    };

    const meses = multiplicadores[periodo] || 1;
    const totalBruto = precio * meses;
    const ahorro = totalBruto * (descuento / 100);
    const precioFinal = totalBruto - ahorro;

    const fTime = (t: string) => t?.substring(0, 5) || '00:00';

    return (
        <div
            className={`pricing-card card-${tipoNormalizado} ${TarifaActiva ? 'tarifa-activa' : ''}`}
            onMouseEnter={() => setIsHovered(true)}
            onMouseLeave={() => setIsHovered(false)}
            style={
                isHovered
                    ? { transform: 'translateY(-5px)', position: 'relative' }
                    : { position: 'relative' }
            }
        >
            {descuento > 0 && (
                <div className="badge-descuento-superior">
                    -{Math.round(descuento)}%
                </div>
            )}

            {(is_admin || is_jefe) && (
                <Button
                    className="pricing-edit-button"
                    href={route('tarifas.edit', id)}
                >
                    <Pencil size={16} />
                </Button>
            )}

            {TarifaActiva && (
                <div className="badge-plan-actual">Tu plan actual</div>
            )}

            <div className="pricing-card-header">
                <h2 className="font-bold uppercase">{tipo}</h2>
                <div className="precio">
                    <span className="precio-término">€</span>
                    {precioFinal.toFixed(2)}
                </div>
                <span className="precio-periodo">pago único / {periodo}</span>

                {descuento > 0 && (
                    <div className="text-sm line-through opacity-50">
                        Antes: {totalBruto.toFixed(2)}€
                    </div>
                )}
            </div>

            <div className="pricing-card-body">
                <ul className="pricing-descripcion">
                    <li className="flex items-center gap-2">
                        <Clock size={16} className="text-current opacity-70" />
                        <span>
                            Acceso: {fTime(hora_inicio)} a {fTime(hora_fin)}
                        </span>
                    </li>
                    <li className="flex items-center gap-2">
                        <CalendarDays
                            size={16}
                            className="text-current opacity-70"
                        />
                        <span>
                            {reservas_semanales >= 90
                                ? 'Reservas ilimitadas'
                                : `Máx. ${reservas_semanales} reservas / sem`}
                        </span>
                    </li>
                </ul>

                {!(is_admin || is_jefe) && (
                    <Button
                        className={`pricing-button ${TarifaActiva ? 'button-disabled' : ''}`}
                        href={
                            TarifaActiva
                                ? '#'
                                : route('socio.create', {
                                      centro_id: centro_id,
                                      tarifa_id: id,
                                  })
                        }
                        disabled={TarifaActiva}
                    >
                        {TarifaActiva ? 'Suscrito' : 'Suscribirse'}
                    </Button>
                )}
            </div>
        </div>
    );
}
