import { Link } from '@inertiajs/react';
import { CatalogImage } from '@/components/catalog/catalog-image';
import { Button } from '@/components/ui/button';
import { CatalogHead } from '@/layouts/catalog-layout';
import { contact } from '@/routes/catalog';
import type {
    CatalogBusiness,
    CatalogImage as CatalogImageType,
    CatalogProjectDetail,
} from '@/types/catalog';

function ImagePair({
    title,
    images,
}: {
    title: string;
    images: CatalogImageType[];
}) {
    if (images.length === 0) {
        return null;
    }

    return (
        <div className="space-y-2">
            <h2 className="text-sm font-medium tracking-wide text-muted-foreground uppercase">
                {title}
            </h2>
            <div className="grid gap-3">
                {images.map((image) => (
                    <CatalogImage
                        key={image.url}
                        src={image.url}
                        alt={image.alt ?? title}
                        className="aspect-[4/3] w-full rounded-xl"
                    />
                ))}
            </div>
        </div>
    );
}

export default function ProjectShow({
    business,
    project,
}: {
    business: CatalogBusiness;
    project: CatalogProjectDetail;
}) {
    return (
        <>
            <CatalogHead title={project.name} business={business} />
            <article className="space-y-6">
                <h1 className="text-3xl font-semibold tracking-tight">
                    {project.name}
                </h1>
                <p className="text-muted-foreground">{project.description}</p>

                <ImagePair title="Before" images={project.images.before} />
                <ImagePair title="After" images={project.images.after} />
                <ImagePair title="Gallery" images={project.images.gallery} />

                {project.work_items.length > 0 ? (
                    <div className="space-y-2">
                        <h2 className="text-lg font-semibold">Work</h2>
                        <ul className="list-disc space-y-1 pl-5 text-muted-foreground">
                            {project.work_items.map((item) => (
                                <li key={item}>{item}</li>
                            ))}
                        </ul>
                    </div>
                ) : null}

                {project.price_label ? (
                    <p className="rounded-xl bg-muted/60 px-4 py-3 text-sm">
                        Estimated price:{' '}
                        <span className="font-semibold">
                            {project.price_label}
                        </span>
                    </p>
                ) : null}

                <Button asChild size="lg" className="h-12 w-full rounded-xl">
                    <Link href={contact(business.slug)}>
                        {project.cta_label}
                    </Link>
                </Button>
            </article>
        </>
    );
}
