import React from 'react';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import '../../../css/noticia/formulario.css';
import { Input } from '@/components/ui/input';
import Button from '@/components/Layouts/Button';

interface Props {
    centro: { id: number; nombre: string };
}

export default function CrearValoracion({ centro }: Props) {
    const { data, setData, post, processing, errors, clearErrors, setError } =
        useForm({
            titulo: '',
            comentario: '',
            puntuacion: 0,
            centro_id: centro.id,
        });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        clearErrors();

        let tieneErrores = false;

        if (!data.puntuacion || data.puntuacion === 0) {
            setError('puntuacion', 'Debes seleccionar al menos una estrella.');
            tieneErrores = true;
        }

        if (!data.titulo.trim()) {
            setError('titulo', 'El título es obligatorio.');
            tieneErrores = true;
        }

        if (!data.comentario.trim()) {
            setError('comentario', 'El comentario es obligatorio.');
            tieneErrores = true;
        }

        if (tieneErrores) return;

        post(route('valoraciones.store'));
    };

    return (
        <>
            <Head title={`Valorar ${centro.nombre}`} />
            <form onSubmit={handleSubmit}>
                <div className="cn-page">
                    <div className="cn-wrap">
                        <div className="cn-section-header">
                            <p className="cn-section-title">
                                Valorar centro: {centro.nombre}
                            </p>
                            <p className="cn-section-subtitle">
                                Comparte tu opinión con la comunidad. Tu
                                valoración ayudará a otros usuarios.
                            </p>
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Puntuación</label>
                            <div className="flex gap-2 py-2">
                                {[1, 2, 3, 4, 5].map((num) => (
                                    <span
                                        key={num}
                                        style={{
                                            fontSize: '30px',
                                            cursor: 'pointer',
                                            color:
                                                num <= data.puntuacion
                                                    ? '#ffc107'
                                                    : '#ddd',
                                            transition: 'none',
                                        }}
                                        onClick={() =>
                                            setData('puntuacion', num)
                                        }
                                    >
                                        ★
                                    </span>
                                ))}
                            </div>
                            {errors.puntuacion && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.puntuacion}
                                </span>
                            )}
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">
                                Resumen de tu opinión
                            </label>
                            <Input
                                name="titulo"
                                placeholder="Ej: Excelente trato o Instalaciones modernas"
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
                            <label className="cn-label">
                                Comentario detallado
                            </label>
                            <textarea
                                name="comentario"
                                placeholder="Cuéntanos más sobre tu experiencia en este centro..."
                                rows={6}
                                className="cn-textarea"
                                value={data.comentario}
                                onChange={(e) =>
                                    setData('comentario', e.target.value)
                                }
                            />
                            {errors.comentario && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.comentario}
                                </span>
                            )}
                        </div>

                        <hr className="cn-divider" />

                        <div className="cn-actions">
                            <Button
                                href={route('centros.show', centro.id)}
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
                                {processing
                                    ? 'Enviando...'
                                    : 'Publicar valoración'}
                            </Button>
                        </div>
                    </div>
                </div>
            </form>
        </>
    );
}
