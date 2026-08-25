import { Link } from '@inertiajs/react';
import { CatalogImage } from '@/components/catalog/catalog-image';
import { Button } from '@/components/ui/button';
import { CatalogHead } from '@/layouts/catalog-layout';
import { login } from '@/routes';
import { home as catalogHome } from '@/routes/catalog';
import type { CatalogDirectoryItem } from '@/types/catalog';

export default function Directory({
    businesses,
}: {
    businesses: CatalogDirectoryItem[];
}) {
    return (
        <>
            <CatalogHead title="Businesses" />
            <section className="space-y-6">
                <div>
                    <p className="text-sm font-medium tracking-wide text-muted-foreground uppercase">
                        Choose a shop
                    </p>
                    <h1 className="mt-1 text-3xl font-semibold tracking-tight">
                        Service catalog
                    </h1>
                    <p className="mt-2 max-w-prose text-muted-foreground">
                        Browse work, approximate prices, and contact details.
                        Opens in the browser or inside Telegram.
                    </p>
                </div>

                {businesses.length === 0 ? (
                    <p className="rounded-xl border border-dashed p-8 text-center text-muted-foreground">
                        No published businesses yet.
                    </p>
                ) : (
                    <ul className="grid gap-4">
                        {businesses.map((business) => (
                            <li key={business.slug}>
                                <Link
                                    href={catalogHome(business.slug)}
                                    className="flex gap-4 rounded-2xl border bg-card p-4 shadow-sm transition hover:border-primary/40"
                                >
                                    <CatalogImage
                                        src={business.logo_url}
                                        alt=""
                                        className="size-16 shrink-0 rounded-xl"
                                    />
                                    <span className="min-w-0">
                                        <span className="block font-semibold">
                                            {business.name}
                                        </span>
                                        <span className="mt-1 line-clamp-2 text-sm text-muted-foreground">
                                            {business.description}
                                        </span>
                                    </span>
                                </Link>
                            </li>
                        ))}
                    </ul>
                )}

                <div className="pt-2">
                    <Button variant="ghost" asChild>
                        <Link href={login()}>Staff login</Link>
                    </Button>
                </div>
            </section>
        </>
    );
}
