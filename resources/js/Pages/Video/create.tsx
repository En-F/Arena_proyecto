// CrearNoticia.jsx
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import '../../../css/noticia/formulario.css';
import { Input } from '@/components/ui/input';
import Button from '@/components/Layouts/Button';

export default function CrearNoticia({ actividad_id }) {
    const { data, setData, post, processing, errors, setError, clearErrors } =
        useForm({
            titulo: '',
            url: '',
            regresar_a_id: actividad_id,
            tipo: 'actividad',
        });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        clearErrors();

        let tieneErrores = false;

        const regexSoloLetrasYNumeros = /^[a-zA-ZÀ-ÿ\s]+$/;

        if (data.titulo && !regexSoloLetrasYNumeros.test(data.titulo)) {
            setError(
                'titulo',
                'El título solo puede contener letras y números (sin símbolos).',
            );
            tieneErrores = true;
        }

        const camposObligatorios = [
            { id: 'titulo', valor: data.titulo, nombre: 'Título' },
            { id: 'url', valor: data.url, nombre: 'url' },
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

        post(route('videos.store'), {
            forceFormData: true,
        });
    };

    return (
        <>
            <form onSubmit={handleSubmit}>
                <div className="cn-page">
                    <div className="cn-wrap">
                        <div className="cn-section-header">
                            <p className="cn-section-title">Crear Video</p>
                            <p className="cn-section-subtitle">
                                Esta información se mostrará públicamente. Sé
                                cuidadoso con lo que publicas.
                            </p>
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Título</label>
                            <Input
                                name="titulo"
                                placeholder="Escribe el titular de la noticia"
                                value={data.titulo}
                                onChange={(e) =>
                                    setData('titulo', e.target.value)
                                }
                                className="cn-input"
                            />
                            {errors.titulo && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.titulo}
                                </span>
                            )}
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Url</label>
                            <Input
                                name="url"
                                type="url"
                                placeholder="Escribe la dirección del video"
                                value={data.url}
                                onChange={(e) => setData('url', e.target.value)}
                                className="cn-input"
                            />
                            {errors.url && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.url}
                                </span>
                            )}
                        </div>

                        <div className="cn-section-header"></div>
                        <div className="cn-actions">
                            <Button
                                href={route('actividades.show', actividad_id)}
                                type="button"
                                className="cn-btn-cancel"
                            >
                                Cancelar
                            </Button>
                            <Button
                                type="submit"
                                className="cn-btn-save"
                                disabled={processing}
                            >
                                {processing ? 'Enviando...' : 'Guardar noticia'}
                            </Button>
                        </div>
                    </div>
                </div>
            </form>
        </>
    );
}
