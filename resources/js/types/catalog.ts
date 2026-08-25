export type CatalogBusiness = {
    name: string;
    slug: string;
    description: string;
    logo_url: string | null;
    currency: string;
    services_cta_label: string;
    portfolio_cta_label: string;
    contact_cta_label: string;
};

export type CatalogDirectoryItem = {
    name: string;
    slug: string;
    description: string;
    logo_url: string | null;
};

export type CatalogContact = {
    phone: string | null;
    email: string | null;
    telegram: string | null;
    address: string | null;
};

export type CatalogService = {
    name: string;
    slug: string;
    description: string;
    price_label: string | null;
    duration_estimate: string | null;
    cta_label: string;
    category: string | null;
};

export type CatalogCategory = {
    name: string;
    slug: string;
    services: CatalogService[];
};

export type CatalogImage = {
    url: string;
    alt: string | null;
};

export type CatalogProjectSummary = {
    name: string;
    slug: string;
    description: string;
    price_label: string | null;
    cta_label: string;
    work_items: string[];
    cover_url: string | null;
    cover_alt: string | null;
};

export type CatalogProjectDetail = CatalogProjectSummary & {
    images: {
        before: CatalogImage[];
        after: CatalogImage[];
        gallery: CatalogImage[];
    };
};
