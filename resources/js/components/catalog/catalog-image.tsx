import { useState } from 'react';
import { cn } from '@/lib/utils';

export function CatalogImage({
    src,
    alt,
    className,
}: {
    src: string | null;
    alt: string;
    className?: string;
}) {
    const [failed, setFailed] = useState(false);

    if (!src || failed) {
        return (
            <div
                className={cn(
                    'flex items-center justify-center bg-muted text-sm text-muted-foreground',
                    className,
                )}
            >
                No image
            </div>
        );
    }

    return (
        <img
            src={src}
            alt={alt}
            onError={() => setFailed(true)}
            className={cn('object-cover', className)}
        />
    );
}
