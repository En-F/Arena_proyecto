import { Input } from '@/components/ui/input';
import { useForm, usePage } from '@inertiajs/react';


export default function Contacto() {
    const {
        data,
        setData,
        post,
        processing,
        reset,
        errors,
        setError,
        clearErrors,
    } = useForm({
        nombre: '',
        email: '',
        mensaje: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        clearErrors();

        let tieneErrores = false;

        const regexSoloLetrasYNumeros = /^[a-zA-ZÀ-ÿ\s]+$/;

        if (data.nombre && !regexSoloLetrasYNumeros.test(data.nombre)) {
            setError('nombre', 'El título solo puede contener letras.');
            tieneErrores = true;
        }

        const camposObligatorios = [
            { id: 'nombre', valor: data.nombre, nombre: 'Título' },
            { id: 'email', valor: data.email, nombre: 'Email' },
            { id: 'mensaje', valor: data.mensaje, nombre: 'mensaje' },
        ];

        camposObligatorios.forEach((campo) => {
            if (
                campo.valor === null ||
                campo.valor === undefined ||
                campo.valor.toString().trim() === ''
            ) {
                setError(
                    campo.id as any,
                    `El campo ${campo.nombre} es obligatorio.`,
                );
                tieneErrores = true;
            }
        });

        if (tieneErrores) return;

        post(route('contacto.enviar'), {
            forceFormData: true,
            onSuccess: () => {
                reset();
            },
        });
    };

    return (
        <div className="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div className="overflow-hidden rounded-2xl bg-white shadow-xl">
                <div className="flex flex-col md:flex-row">
                    <div className="w-full p-8 md:w-1/2 lg:p-12">
                        <h2 className="mb-2 text-3xl font-extrabold text-gray-900">
                            Ponte en contacto
                        </h2>
                        <p className="mb-8 text-gray-500">
                            Estamos aquí para ayudarte. Cuéntanos qué necesitas.
                        </p>

                        <form onSubmit={handleSubmit} className="space-y-5">
                            <div>
                                <label className="block text-sm font-semibold text-gray-700">
                                    Nombre completo
                                </label>
                                <Input
                                    type="text"
                                    className="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    value={data.nombre}
                                    onChange={(e) =>
                                        setData('nombre', e.target.value)
                                    }
                                />
                                {errors.nombre && (
                                    <span className="text-xs text-red-500">
                                        {errors.nombre}
                                    </span>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-semibold text-gray-700">
                                    Correo electrónico
                                </label>
                                <Input
                                    type="email"
                                    className="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    value={data.email}
                                    onChange={(e) =>
                                        setData('email', e.target.value)
                                    }
                                />
                                {errors.email && (
                                    <span className="text-xs text-red-500">
                                        {errors.email}
                                    </span>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-semibold text-gray-700">
                                    Mensaje
                                </label>
                                <textarea
                                    rows="4"
                                    className="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    value={data.mensaje}
                                    onChange={(e) =>
                                        setData('mensaje', e.target.value)
                                    }
                                ></textarea>
                                {errors.mensaje && (
                                    <span className="text-xs text-red-500">
                                        {errors.mensaje}
                                    </span>
                                )}
                            </div>

                            <button
                                disabled={processing}
                                className="w-full rounded-lg bg-blue-600 px-6 py-3 font-bold text-white shadow-lg transition duration-200 hover:bg-blue-700"
                            >
                                {processing ? 'Enviando...' : 'Enviar mensaje'}
                            </button>
                        </form>
                    </div>

                    <div className="hidden md:block md:w-1/2">
                        <img
                            src="/storage/otros/ciudad.jpg"
                            alt="Contacto"
                            className="h-full w-full object-cover"
                        />
                    </div>
                </div>
            </div>
        </div>
    );
}
