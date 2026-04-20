// resources/js/Components/ActivityCard.jsx
import '../../../css/carta/carta_video.css';

interface Props {
    id: number;
    titulo: string;
    url: string;
}

function getYoutubeId(url: string): string | null {
    const match = url.match(/(?:v=|youtu\.be\/)([^&?/]+)/);
    return match?.[1] ?? null;
}

export default function CartaActividad({ id, url, titulo }: Props) {
    const videoId = getYoutubeId(url);

    if (!videoId) {
        return (
            <div className="video-card-wrapper">
                <div
                    className="video-card"
                    style={{
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                    }}
                >
                    <p style={{ color: '#999' }}>URL de YouTube no válida</p>
                </div>
                <p className="video-footer-title">{titulo}</p>
            </div>
        );
    }

    return (
        <div className="video-card-wrapper">
            <div className="video-card">
                <iframe
                    src={`https://www.youtube.com/embed/${videoId}`}
                    title={titulo}
                    allowFullScreen
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    style={{
                        position: 'absolute',
                        top: 0,
                        left: 0,
                        width: '100%',
                        height: '100%',
                        border: 'none',
                        borderRadius: '12px',
                    }}
                />
            </div>
        </div>
    );
}
