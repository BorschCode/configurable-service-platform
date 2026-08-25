import { Link } from '@inertiajs/react';
import { CatalogImage } from '@/components/catalog/catalog-image';
import { Button } from '@/components/ui/button';
import { CatalogHead } from '@/layouts/catalog-layout';
import { contact } from '@/routes/catalog';
import { show as projectShow } from '@/routes/catalog/portfolio';
import type {
    CatalogBusiness,
    CatalogProjectSummary,
    CatalogService,
} from '@/types/catalog';

export default function ServiceShow({
    business,
    service,
    projects,
}: {
    business: CatalogBusiness;
    service: CatalogService;
    projects: CatalogProjectSummary[];
}) {
    return (
        <>
            <CatalogHead title={service.name} business={business} />
            <article className="space-y-6">
                {service.category ? (
                    <p className="text-sm font-medium text-muted-foreground">
                        {service.category}
                    </p>
                ) : null}
                <h1 className="text-3xl font-semibold tracking-tight">
                    {service.name}
                </h1>
                <p className="text-muted-foreground">{service.description}</p>
                <dl className="grid gap-2 text-sm">
                    {service.price_label ? (
                        <div className="flex justify-between gap-4 rounded-xl bg-muted/60 px-4 py-3">
                            <dt className="text-muted-foreground">From</dt>
                            <dd className="font-medium">
                                {service.price_label}
                            </dd>
                        </div>
                    ) : null}
                    {service.duration_estimate ? (
                        <div className="flex justify-between gap-4 rounded-xl bg-muted/60 px-4 py-3">
                            <dt className="text-muted-foreground">Duration</dt>
                            <dd className="font-medium">
                                {service.duration_estimate}
                            </dd>
                        </div>
                    ) : null}
                </dl>

                <Button asChild size="lg" className="h-12 w-full rounded-xl">
                    <Link href={contact(business.slug)}>
                        {service.cta_label}
                    </Link>
                </Button>

                <section className="space-y-3">
                    <h2 className="text-lg font-semibold">Examples</h2>
                    {projects.length === 0 ? (
                        <p className="text-sm text-muted-foreground">
                            No project examples for this service yet.
                        </p>
                    ) : (
                        <ul className="grid gap-4 sm:grid-cols-2">
                            {projects.map((project) => (
                                <li key={project.slug}>
                                    <Link
                                        href={projectShow({
                                            business: business.slug,
                                            project: project.slug,
                                        })}
                                        className="block overflow-hidden rounded-xl border bg-card"
                                    >
                                        <CatalogImage
                                            src={project.cover_url}
                                            alt={
                                                project.cover_alt ??
                                                project.name
                                            }
                                            className="aspect-[4/3] w-full"
                                        />
                                        <span className="block p-3 font-medium">
                                            {project.name}
                                        </span>
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    )}
                </section>
            </article>
        </>
    );
}
