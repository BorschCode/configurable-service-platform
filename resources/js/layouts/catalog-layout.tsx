import { Head, Link, usePage } from '@inertiajs/react';
import { useTelegramHost } from '@/hooks/use-telegram-host';
import { CatalogNav } from '@/layouts/catalog-nav';
import { home as catalogHome } from '@/routes/catalog';
import type { CatalogBusiness, CatalogDirectoryItem } from '@/types/catalog';

export default function CatalogLayout({
    children,
}: {
    children: React.ReactNode;
}) {
    const { component, props } = usePage<{
        business?: CatalogBusiness;
        businesses?: CatalogDirectoryItem[];
    }>();

    const business = props.business;
    const isDirectory = component === 'catalog/directory';
    const isHome = component === 'catalog/home';

    useTelegramHost({
        directorySlugs: (props.businesses ?? []).map((item) => item.slug),
        showBack: !isDirectory && !isHome,
        homeUrl: business ? catalogHome.url(business.slug) : undefined,
    });

    return (
        <div className="catalog-shell">
            <div className="mx-auto flex min-h-dvh max-w-lg flex-col px-4 pt-6 pb-20 sm:max-w-3xl sm:pb-10">
                <header className="mb-6 flex items-center justify-between gap-3">
                    {business ? (
                        <Link
                            href={catalogHome(business.slug)}
                            className="flex min-w-0 items-center gap-3"
                        >
                            {business.logo_url ? (
                                <img
                                    src={business.logo_url}
                                    alt=""
                                    className="size-10 rounded-full object-cover"
                                />
                            ) : (
                                <span className="flex size-10 items-center justify-center rounded-full bg-primary text-sm font-semibold text-primary-foreground">
                                    {business.name.slice(0, 1)}
                                </span>
                            )}
                            <span className="truncate font-semibold tracking-tight">
                                {business.name}
                            </span>
                        </Link>
                    ) : (
                        <p className="font-semibold tracking-tight">
                            Service catalog
                        </p>
                    )}
                </header>

                <main className="flex-1">{children}</main>

                {business ? <CatalogNav business={business} /> : null}
            </div>
        </div>
    );
}

export function CatalogHead({
    title,
    business,
}: {
    title: string;
    business?: CatalogBusiness;
}) {
    return <Head title={business ? `${title} · ${business.name}` : title} />;
}
