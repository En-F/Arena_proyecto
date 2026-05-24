import { useForm, usePage } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import Button from '@/components/Layouts/Button';
import { ChartNoAxesColumn, Eye, EyeOff } from 'lucide-react';
import { Input } from '@/components/ui/input';

interface Tarifa {
    id: number;
    tipo: string;
    precio: number;
}

interface Centro {
    id: number;
    nombre: string;
    tarifas: Tarifa[];
    periodo: string;
    tipo: string;
    descuento: number;
}

interface Props {
    centros: Centro[];
    centro_id_pre?: number | string;
    tarifa_id_pre?: number | string;
}

export default function InscripcionForm({
    centros,
    centro_id_pre,
    tarifa_id_pre,
}: Props) {
    const { auth } = usePage().props as any;
    const [tarifasFiltradas, setTarifasFiltradas] = useState<Tarifa[]>([]);
    const [showPassword, setShowPassword] = useState(false);
    console.log('Props recibidas:', { centro_id_pre, tarifa_id_pre });
    const { data, setData, post, processing, errors, setError, clearErrors } =
        useForm({
            centro_id: centro_id_pre || '',
            tarifa_id: tarifa_id_pre || '',
            name: auth.user?.name || '',
            email: auth.user?.email || '',
            password: '',
            password_confirmation: '',
            dni: auth.user?.dni || '',
            telefono: auth.user?.telefono || '',
        });

    useEffect(() => {
        if (data.centro_id) {
            const centroSeleccionado = centros.find(
                (c) => c.id == data.centro_id,
            );

            if (centroSeleccionado) {
                setTarifasFiltradas(centroSeleccionado.tarifas || []);

                const tarifaEsValida = centroSeleccionado.tarifas.some(
                    (t) => t.id == data.tarifa_id,
                );

                if (!tarifaEsValida) {
                    setData('tarifa_id', '');
                }
            }
        } else {
            setTarifasFiltradas([]);
            setData('tarifa_id', '');
        }
    }, [data.centro_id]);

    const validarDNI = (dni: string): boolean => {
        const regex = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i;
        if (!regex.test(dni)) return false;
        const letras = 'TRWAGMYFPDXBNJZSQVHLCKE';
        const numero = parseInt(dni.substring(0, 8), 10);
        const letraEntregada = dni.substring(8).toUpperCase();
        return letraEntregada === letras[numero % 23];
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        clearErrors();

        let tieneErrores = false;
        const regexLetras = /^[a-zA-ZÀ-ÿ\s]+$/;
        const regexPass = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/;
        const regexTel = /^\d{9}$/;

        if (!auth.user) {
            if (data.name && !regexLetras.test(data.name)) {
                setError('name', 'El nombre solo puede contener letras.');
                tieneErrores = true;
            }
            if (!regexPass.test(data.password)) {
                setError(
                    'password',
                    'Mínimo 8 caracteres, una mayúscula, una minúscula y un símbolo.',
                );
                tieneErrores = true;
            }
        }

        if (data.dni && !validarDNI(data.dni)) {
            setError('dni', 'DNI no válido.');
            tieneErrores = true;
        }

        if (data.telefono && !regexTel.test(data.telefono)) {
            setError('telefono', 'Teléfono no válido (9 dígitos).');
            tieneErrores = true;
        }

        const obligatorios = [
            { id: 'centro_id', valor: data.centro_id, nombre: 'Centro' },
            { id: 'tarifa_id', valor: data.tarifa_id, nombre: 'Tarifa' },
            { id: 'dni', valor: data.dni, nombre: 'DNI' },
            { id: 'telefono', valor: data.telefono, nombre: 'Teléfono' },
        ];

        if (!auth.user) {
            obligatorios.push(
                { id: 'name', valor: data.name, nombre: 'Nombre' },
                { id: 'email', valor: data.email, nombre: 'Email' },
            );
        }

        obligatorios.forEach((campo) => {
            if (!campo.valor?.toString().trim()) {
                setError(
                    campo.id as any,
                    `El campo ${campo.nombre} es obligatorio.`,
                );
                tieneErrores = true;
            }
        });

        if (!tieneErrores) post(route('socio.store'), { forceFormData: true });
    };

    return (
        <div className="flex min-h-screen items-center justify-center bg-gray-100 p-0 text-left sm:p-6">
            <div className="flex min-h-screen w-full max-w-6xl flex-col overflow-hidden bg-white shadow-2xl md:min-h-[600px] md:flex-row md:rounded-3xl">
                <div className="flex w-full flex-col justify-center p-6 sm:p-10 md:w-1/2 lg:p-16">
                    <div className="mx-auto w-full max-w-md">
                        <header className="mb-8">
                            <h2 className="text-3xl leading-tight font-black text-gray-900">
                                Finaliza tu Inscripción
                            </h2>
                            <p className="mt-2 text-gray-500">
                                Completa tus datos y activa tu acceso al centro.
                            </p>
                        </header>

                        <form onSubmit={handleSubmit} className="space-y-5">
                            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div className="space-y-1">
                                    <label className="ml-1 text-xs font-bold text-gray-400 uppercase">
                                        Centro
                                    </label>
                                    <select
                                        className={`w-full rounded-xl border-gray-200 bg-gray-50 p-3 outline-none focus:ring-2 focus:ring-blue-500 ${errors.centro_id ? 'border-red-500' : ''}`}
                                        value={data.centro_id}
                                        onChange={(e) =>
                                            setData('centro_id', e.target.value)
                                        }
                                        disabled={!!centro_id_pre}
                                    >
                                        <option value="">
                                            Selecciona Centro
                                        </option>
                                        {centros.map((c) => (
                                            <option key={c.id} value={c.id}>
                                                {c.nombre}
                                            </option>
                                        ))}
                                    </select>
                                    {errors.centro_id && (
                                        <p className="mt-1 text-[10px] text-red-500">
                                            {errors.centro_id}
                                        </p>
                                    )}
                                </div>
                                <div className="space-y-1">
                                    <label className="ml-1 text-xs font-bold text-gray-400 uppercase">
                                        Tarifa
                                    </label>
                                    <select
                                        className={`w-full rounded-xl border-gray-200 bg-gray-50 p-3 outline-none focus:ring-2 focus:ring-blue-500 ${errors.tarifa_id ? 'border-red-500' : ''}`}
                                        value={data.tarifa_id}
                                        onChange={(e) =>
                                            setData('tarifa_id', e.target.value)
                                        }
                                        disabled={
                                            !!tarifa_id_pre ||
                                            tarifasFiltradas.length === 0
                                        }
                                    >
                                        <option value="">
                                            Selecciona Tarifa
                                        </option>
                                        {tarifasFiltradas.map((t) => {
                                            const meses =
                                                t.periodo === 'trimestre'
                                                    ? 3
                                                    : t.periodo === 'semestre'
                                                      ? 6
                                                      : 1;
                                            const precioMensual =
                                                (t.precio / meses) *
                                                (1 - t.descuento / 100);
                                            return (
                                                <option key={t.id} value={t.id}>
                                                    {t.tipo.toUpperCase()} -{' '}
                                                    {precioMensual.toFixed(2)}
                                                    €/mes
                                                </option>
                                            );
                                        })}
                                    </select>
                                    {errors.tarifa_id && (
                                        <p className="mt-1 text-[10px] text-red-500">
                                            {errors.tarifa_id}
                                        </p>
                                    )}
                                </div>
                            </div>

                            {!auth.user && (
                                <div className="space-y-3 rounded-2xl border border-blue-100 bg-blue-50 p-5">
                                    <p className="mb-2 text-[10px] font-black tracking-widest text-blue-500 uppercase">
                                        Crear nueva cuenta
                                    </p>
                                    <Input
                                        placeholder="Nombre"
                                        value={data.name}
                                        onChange={(e) =>
                                            setData('name', e.target.value)
                                        }
                                        className="bg-white"
                                    />
                                    {errors.name && (
                                        <p className="text-[10px] text-red-500">
                                            {errors.name}
                                        </p>
                                    )}

                                    <Input
                                        type="email"
                                        placeholder="Email"
                                        value={data.email}
                                        onChange={(e) =>
                                            setData('email', e.target.value)
                                        }
                                        className="bg-white"
                                    />
                                    {errors.email && (
                                        <p className="text-[10px] text-red-500">
                                            {errors.email}
                                        </p>
                                    )}

                                    <div className="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                        <div className="relative">
                                            <Input
                                                type={
                                                    showPassword
                                                        ? 'text'
                                                        : 'password'
                                                }
                                                placeholder="Contraseña"
                                                className="bg-white pr-10"
                                                onChange={(e) =>
                                                    setData(
                                                        'password',
                                                        e.target.value,
                                                    )
                                                }
                                            />
                                            <button
                                                type="button"
                                                onClick={() =>
                                                    setShowPassword(
                                                        !showPassword,
                                                    )
                                                }
                                                className="absolute top-1/2 right-3 -translate-y-1/2 text-gray-400 hover:text-blue-500"
                                            >
                                                {showPassword ? (
                                                    <EyeOff size={16} />
                                                ) : (
                                                    <Eye size={16} />
                                                )}
                                            </button>
                                        </div>
                                        <Input
                                            type={
                                                showPassword
                                                    ? 'text'
                                                    : 'password'
                                            }
                                            placeholder="Repetir"
                                            className="bg-white"
                                            onChange={(e) =>
                                                setData(
                                                    'password_confirmation',
                                                    e.target.value,
                                                )
                                            }
                                        />
                                    </div>
                                    {errors.password && (
                                        <p className="text-[10px] text-red-500">
                                            {errors.password}
                                        </p>
                                    )}
                                </div>
                            )}

                            <div className="space-y-3">
                                <p className="ml-1 text-[10px] font-black tracking-widest text-gray-400 uppercase">
                                    Información de socio
                                </p>
                                <div className="grid grid-cols-2 gap-3">
                                    <div className="flex flex-col">
                                        <Input
                                            placeholder="DNI"
                                            value={data.dni}
                                            onChange={(e) =>
                                                setData('dni', e.target.value)
                                            }
                                        />
                                        {errors.dni && (
                                            <p className="mt-1 text-[10px] text-red-500">
                                                {errors.dni}
                                            </p>
                                        )}
                                    </div>
                                    <div className="flex flex-col">
                                        <Input
                                            placeholder="Teléfono"
                                            value={data.telefono}
                                            onChange={(e) =>
                                                setData(
                                                    'telefono',
                                                    e.target.value,
                                                )
                                            }
                                        />
                                        {errors.telefono && (
                                            <p className="mt-1 text-[10px] text-red-500">
                                                {errors.telefono}
                                            </p>
                                        )}
                                    </div>
                                </div>
                            </div>

                            <div className="pt-4">
                                <Button
                                    disabled={processing}
                                    type="submit"
                                    className="flex w-full items-center justify-center gap-2 rounded-2xl bg-slate-900 py-6 text-lg font-bold text-white transition-all hover:bg-black"
                                >
                                    {processing
                                        ? 'Cargando...'
                                        : 'Pagar y unirme ahora'}
                                    {!processing && (
                                        <Eye
                                            size={20}
                                            className="opacity-0 group-hover:opacity-100"
                                        />
                                    )}
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>

                <div className="relative hidden w-1/2 md:block">
                    <img
                        src="/storage/otros/socio.jpeg"
                        alt="Fitness"
                        className="absolute inset-0 h-full w-full object-cover"
                    />
                    <div className="absolute inset-0 flex items-end bg-gradient-to-tr from-black/80 via-black/20 to-transparent p-16">
                        <div className="space-y-2 text-white">
                            <h3 className="text-4xl font-black">
                                Transforma tu vida hoy.
                            </h3>
                            <p className="text-lg text-gray-300">
                                Acceso instantáneo con tu código QR personal.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
