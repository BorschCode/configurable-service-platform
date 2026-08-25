import { router } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import { home as catalogHome } from '@/routes/catalog';

type TelegramHostOptions = {
    directorySlugs?: string[];
    showBack?: boolean;
    homeUrl?: string;
};

export function useTelegramHost({
    directorySlugs = [],
    showBack = false,
    homeUrl,
}: TelegramHostOptions): { isTelegram: boolean } {
    const [isTelegram, setIsTelegram] = useState(false);

    const slugsKey = directorySlugs.join(',');

    useEffect(() => {
        let cancelled = false;
        let unsubscribe: VoidFunction | undefined;

        async function setup(): Promise<void> {
            try {
                const sdk = await import('@telegram-apps/sdk-react');
                const inTelegram = await Promise.resolve(sdk.isTMA());

                if (!inTelegram || cancelled) {
                    return;
                }

                sdk.init();

                if (sdk.miniApp.mount.isAvailable()) {
                    await sdk.miniApp.mount();
                }

                sdk.miniApp.ready.ifAvailable();

                if (sdk.themeParams.mount.isAvailable()) {
                    sdk.themeParams.mount();
                    sdk.themeParams.bindCssVars.ifAvailable();
                }

                if (sdk.viewport.mount.isAvailable()) {
                    await sdk.viewport.mount();
                    sdk.viewport.bindCssVars.ifAvailable();
                    sdk.viewport.expand.ifAvailable();
                }

                if (sdk.backButton.mount.isAvailable()) {
                    sdk.backButton.mount();
                }

                if (cancelled) {
                    return;
                }

                setIsTelegram(true);

                if (window.location.pathname === '/') {
                    const startParam =
                        sdk.retrieveLaunchParams().tgWebAppStartParam;
                    const slugs = slugsKey === '' ? [] : slugsKey.split(',');

                    if (
                        typeof startParam === 'string' &&
                        /^[a-z0-9]+(?:-[a-z0-9]+)*$/.test(startParam) &&
                        slugs.includes(startParam)
                    ) {
                        router.visit(catalogHome.url(startParam));
                    }
                }

                if (showBack) {
                    sdk.backButton.show.ifAvailable();
                    unsubscribe = sdk.backButton.onClick(() => {
                        if (window.history.length > 1) {
                            window.history.back();

                            return;
                        }

                        if (homeUrl) {
                            router.visit(homeUrl);
                        }
                    });
                } else {
                    sdk.backButton.hide.ifAvailable();
                }
            } catch (error) {
                console.warn('Telegram host adapter skipped', error);
            }
        }

        void setup();

        return () => {
            cancelled = true;
            unsubscribe?.();
        };
    }, [homeUrl, showBack, slugsKey]);

    return { isTelegram };
}
