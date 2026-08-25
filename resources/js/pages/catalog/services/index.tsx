import { Link } from '@inertiajs/react';
import { CatalogHead } from '@/layouts/catalog-layout';
import { show as serviceShow } from '@/routes/catalog/services';
import type {
    CatalogBusiness,
    CatalogCategory,
    CatalogService,
} from '@/types/catalog';

function ServiceRow({
    business,
    service,
}: {
    business: CatalogBusiness;
    service: CatalogService;
}) {
    return (
        <Link
            href={serviceShow({
                business: business.slug,
                service: service.slug,
            })}
            className="flex items-baseline justify-between gap-3 rounded-xl border bg-card px-4 py-3"
        >
            <span>
                <span className="block font-medium">{service.name}</span>
                {service.duration_estimate ? (
                    <span className="text-xs text-muted-foreground">
                        {service.duration_estimate}
                    </span>
                ) : null}
            </span>
            {service.price_label ? (
                <span className="shrink-0 text-sm font-medium">
                    {service.price_label}
                </span>
            ) : null}
        </Link>
    );
}

export default function ServicesIndex({
    business,
    categories,
    uncategorized,
}: {
    business: CatalogBusiness;
    categories: CatalogCategory[];
    uncategorized: CatalogService[];
}) {
    const empty = categories.length === 0 && uncategorized.length === 0;

    return (
        <>
            <CatalogHead title="Services" business={business} />
            <section className="space-y-8">
                <h1 className="text-3xl font-semibold tracking-tight">
                    Services
                </h1>

                {empty ? (
                    <p className="rounded-xl border border-dashed p-8 text-center text-muted-foreground">
                        No services published yet.
                    </p>
                ) : null}

                {categories.map((category) => (
                    <div key={category.slug} className="space-y-3">
                        <h2 className="text-lg font-semibold">
                            {category.name}
                        </h2>
                        <ul className="grid gap-3">
                            {category.services.map((service) => (
                                <li key={service.slug}>
                                    <ServiceRow
                                        business={business}
                                        service={service}
                                    />
                                </li>
                            ))}
                        </ul>
                    </div>
                ))}

                {uncategorized.length > 0 ? (
                    <div className="space-y-3">
                        <h2 className="text-lg font-semibold">More services</h2>
                        <ul className="grid gap-3">
                            {uncategorized.map((service) => (
                                <li key={service.slug}>
                                    <ServiceRow
                                        business={business}
                                        service={service}
                                    />
                                </li>
                            ))}
                        </ul>
                    </div>
                ) : null}
            </section>
        </>
    );
}
