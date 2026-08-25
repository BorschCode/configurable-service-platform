import { CatalogHead } from '@/layouts/catalog-layout';
import type { CatalogBusiness, CatalogContact } from '@/types/catalog';

function Row({ label, value }: { label: string; value: string }) {
    return (
        <div className="rounded-xl border bg-card px-4 py-3">
            <p className="text-xs font-medium tracking-wide text-muted-foreground uppercase">
                {label}
            </p>
            <p className="mt-1 font-medium break-all">{value}</p>
        </div>
    );
}

export default function Contact({
    business,
    contact,
}: {
    business: CatalogBusiness;
    contact: CatalogContact;
}) {
    const telegramHref = contact.telegram
        ? `https://t.me/${contact.telegram}`
        : null;
    const phoneHref = contact.phone
        ? `tel:${contact.phone.replaceAll(' ', '')}`
        : null;
    const emailHref = contact.email ? `mailto:${contact.email}` : null;

    const empty =
        !contact.phone &&
        !contact.email &&
        !contact.telegram &&
        !contact.address;

    return (
        <>
            <CatalogHead title="Contact" business={business} />
            <section className="space-y-6">
                <div>
                    <h1 className="text-3xl font-semibold tracking-tight">
                        Contact
                    </h1>
                    <p className="mt-2 text-muted-foreground">
                        Reach {business.name} directly. Request forms come later
                        — use the details below for now.
                    </p>
                </div>

                {empty ? (
                    <p className="rounded-xl border border-dashed p-8 text-center text-muted-foreground">
                        No contact details published yet.
                    </p>
                ) : (
                    <div className="grid gap-3">
                        {contact.phone && phoneHref ? (
                            <a href={phoneHref}>
                                <Row label="Phone" value={contact.phone} />
                            </a>
                        ) : null}
                        {contact.telegram && telegramHref ? (
                            <a
                                href={telegramHref}
                                target="_blank"
                                rel="noreferrer"
                            >
                                <Row
                                    label="Telegram"
                                    value={`@${contact.telegram}`}
                                />
                            </a>
                        ) : null}
                        {contact.email && emailHref ? (
                            <a href={emailHref}>
                                <Row label="Email" value={contact.email} />
                            </a>
                        ) : null}
                        {contact.address ? (
                            <Row label="Address" value={contact.address} />
                        ) : null}
                    </div>
                )}
            </section>
        </>
    );
}
