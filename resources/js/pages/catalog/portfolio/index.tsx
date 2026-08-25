import { Link } from '@inertiajs/react';
import { CatalogImage } from '@/components/catalog/catalog-image';
import { CatalogHead } from '@/layouts/catalog-layout';
import { show as projectShow } from '@/routes/catalog/portfolio';
import type { CatalogBusiness, CatalogProjectSummary } from '@/types/catalog';

export default function PortfolioIndex({
    business,
    projects,
}: {
    business: CatalogBusiness;
    projects: CatalogProjectSummary[];
}) {
    return (
        <>
            <CatalogHead title="Portfolio" business={business} />
            <section className="space-y-6">
                <h1 className="text-3xl font-semibold tracking-tight">
                    Portfolio
                </h1>
                {projects.length === 0 ? (
                    <p className="rounded-xl border border-dashed p-8 text-center text-muted-foreground">
                        No projects published yet.
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
                                        alt={project.cover_alt ?? project.name}
                                        className="aspect-[4/3] w-full"
                                    />
                                    <span className="block space-y-1 p-4">
                                        <span className="block font-semibold">
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
            </section>
        </>
    );
}
