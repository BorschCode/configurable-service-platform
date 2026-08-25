import { Link, usePage } from '@inertiajs/react';
import { cn } from '@/lib/utils';
import { contact, home as catalogHome } from '@/routes/catalog';
import { index as portfolioIndex } from '@/routes/catalog/portfolio';
import { index as servicesIndex } from '@/routes/catalog/services';
import type { CatalogBusiness } from '@/types/catalog';

export function CatalogNav({ business }: { business: CatalogBusiness }) {
    const { url } = usePage();
    const slug = business.slug;

    const items = [
        { href: catalogHome.url(slug), label: 'Home', match: `/${slug}` },
        {
            href: servicesIndex.url(slug),
            label: 'Services',
            match: `/${slug}/services`,
        },
        {
            href: portfolioIndex.url(slug),
            label: 'Portfolio',
            match: `/${slug}/portfolio`,
        },
        {
            href: contact.url(slug),
            label: 'Contact',
            match: `/${slug}/contact`,
        },
    ];

    return (
        <nav className="fixed inset-x-0 bottom-0 z-20 border-t border-border/80 bg-background/95 backdrop-blur-md sm:static sm:border-0 sm:bg-transparent sm:backdrop-blur-none">
            <ul className="mx-auto grid max-w-lg grid-cols-4 sm:flex sm:max-w-none sm:justify-center sm:gap-2">
                {items.map((item) => {
                    const active =
                        item.match === `/${slug}`
                            ? url === item.match || url === `${item.match}/`
                            : url.startsWith(item.match);

                    return (
                        <li key={item.href}>
                            <Link
                                href={item.href}
                                className={cn(
                                    'flex h-14 items-center justify-center px-2 text-xs font-medium sm:h-10 sm:rounded-full sm:px-4 sm:text-sm',
                                    active
                                        ? 'text-primary sm:bg-primary sm:text-primary-foreground'
                                        : 'text-muted-foreground hover:text-foreground',
                                )}
                            >
                                {item.label}
                            </Link>
                        </li>
                    );
                })}
            </ul>
        </nav>
    );
}
