export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export interface Event {
    id: number;
    uuid_code: string;
    name: string;
    description: string;
    address: string;
    complement: string;
    zipcode: string;
    number: string;
    city: string;
    state: string;
    starts_at: Date;
    ends_at: Date;
    status_label: string;
    max_subscription: number;
    guests_count: number;
    is_subscribed: boolean;
    is_full: boolean;
}

export interface AddressData {
  address: string;
  number?: string | null;
  complement?: string | null;
  city: string;
  state: string;
  zipcode: string;
}

export interface Paginated<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
}

type TimeProps = {
    hour: number | string;
    minute: number | string;
};

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User;
    };
    flash: FlashMessages;
};
