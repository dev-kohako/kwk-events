import { AddressData } from "@/types";


export function formatAddress(data: AddressData): string {
  const parts: string[] = [];

  parts.push(`${data.address}${data.number ? `, ${data.number}` : ''}`);

  if (data.complement) {
    parts.push(data.complement);
  }

  parts.push(`${data.city} - ${data.state}`);
  parts.push(`CEP: ${data.zipcode}`);

  return parts.join(', ');
}
