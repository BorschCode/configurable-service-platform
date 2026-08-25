import { Link } from '@inertiajs/react';
import { CatalogImage } from '@/components/catalog/catalog-image';
import { Button } from '@/components/ui/button';
import { CatalogHead } from '@/layouts/catalog-layout';
import { contact } from '@/routes/catalog';
import {
    index as portfolioIndex,
    show as projectShow,
} from '@/routes/catalog/portfolio';
import {
    index as servicesIndex,
    show as serviceShow,
} from '@/routes/catalog/services';
import type {
    CatalogBusiness,
    CatalogProjectSummary,
    CatalogService,
} from '@/types/catalog';

export default function Home({
    business,
    services,
    projects,
}: {
    business: CatalogBusiness;
    services: CatalogService[];
    projects: CatalogProjectSummary[];
}) {
    const slug = business.slug;

    return (
        <>
            <CatalogHead title="Home" business={business} />
            <section className="space-y-8">
                <div className="space-y-3">
                    <h1 className="text-3xl font-semibold tracking-tight">
                        {business.name}
                    </h1>
                    <p className="text-muted-foreground">
                        {business.description}
                    </p>
                </div>

                <div className="grid gap-3">
                    <Button asChild size="lg" className="h-12 rounded-xl">
                        <Link href={servicesIndex(slug)}>
                            {business.services_cta_label}
                        </Link>
                    </Button>
                    <Button
                        asChild
                        size="lg"
                        variant="secondary"
                        className="h-12 rounded-xl"
                    >
                        <Link href={portfolioIndex(slug)}>
                            {business.portfolio_cta_label}
                        </Link>
                    </Button>
                    <Button
                        asChild
                        size="lg"
                        variant="outline"
                        className="h-12 rounded-xl"
                    >
                        <Link href={contact(slug)}>
                            {business.contact_cta_label}
                        </Link>
                    </Button>
                </div>

                <div className="space-y-3">
                    <h2 className="text-lg font-semibold">Services</h2>
                    {services.length === 0 ? (
                        <p className="text-sm text-muted-foreground">
                            No services published yet.
                        </p>
                    ) : (
                        <ul className="grid gap-3">
                            {services.map((service) => (
                                <li key={service.slug}>
                                    <Link
                                        href={serviceShow({
                                            business: slug,
                                            service: service.slug,
                                        })}
                                        className="flex items-baseline justify-between gap-3 rounded-xl border bg-card px-4 py-3"
                                    >
                                        <span>
                                            <span className="block font-medium">
                                                {service.name}
                                            </span>
                                            {service.category ? (
                                                <span className="text-xs text-muted-foreground">
                                                    {service.category}
                                                </span>
                                            ) : null}
                                        </span>
                                        {service.price_label ? (
                                            <span className="shrink-0 text-sm font-medium">
                                                {service.price_label}
                                            </span>
                                        ) : null}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>

                <div className="space-y-3">
                    <h2 className="text-lg font-semibold">Recent work</h2>
                    {projects.length === 0 ? (
                        <p className="text-sm text-muted-foreground">
                            No projects published yet.
                        </p>
                    ) : (
                        <ul className="grid gap-4 sm:grid-cols-3">
                            {projects.map((project) => (
                                <li key={project.slug}>
                                    <Link
                                        href={projectShow({
                                            business: slug,
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
                                        <span className="block p-3">
                                            <span className="block font-medium">
                                                {project.name}
                                            </span>
                                            {project.price_label ? (
                                                <span className="text-sm text-muted-foreground">
                                                    {project.price_label}
                                                </span>
                                            ) : null}
                                        </span>
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>
            </section>
        </>
    );
}
