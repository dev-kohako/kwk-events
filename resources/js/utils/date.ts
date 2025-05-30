import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc';
import isSameOrAfter from 'dayjs/plugin/isSameOrAfter';
import isSameOrBefore from 'dayjs/plugin/isSameOrBefore';
import 'dayjs/locale/pt-br';

dayjs.extend(utc);
dayjs.extend(isSameOrAfter);
dayjs.extend(isSameOrBefore);
dayjs.locale('pt-br');

export function getShortMonth(date: Date | string) {
  return dayjs(date).format('MMM').toUpperCase();
}

export function getDayOfMonth(date: Date | string) {
  return dayjs(date).format('DD');
}

export function getWeekdayName(date: Date | string) {
  return dayjs(date).format('dddd');
}

export function getFullDate(date: Date | string) {
  return dayjs(date).format('D [de] MMMM [de] YYYY');
}

export function getTime(date: Date | string) {
  return dayjs(date).format('HH:mm');
}

export function formatDateTimeRange(start: Date | string, end: Date | string) {
  const day = getFullDate(start);
  const startTime = getTime(start);
  const endTime = getTime(end);
  return `${day}, começa às ${startTime}, termina às ${endTime}`;
}

export function isTodayOrFuture(date: Date | string) {
  const today = dayjs().startOf('day');
  return dayjs(date).isSame(today, 'day') || dayjs(date).isAfter(today);
}

export function isEndAfterStart(startDate: string, startTime: string, endDate: string, endTime: string) {
  const startDateTime = dayjs(`${startDate} ${startTime}`, 'YYYY-MM-DD HH:mm');
  const endDateTime = dayjs(`${endDate} ${endTime}`, 'YYYY-MM-DD HH:mm');
  return endDateTime.isAfter(startDateTime);
}

export function isSameOrAfterDate(referenceDate: string, compareDate: string) {
  return dayjs(compareDate).isSameOrAfter(dayjs(referenceDate), 'day');
}

export function toUtcDateString(date: Date | string) {
  return dayjs(date).utc().format('YYYY-MM-DD');
}

export function toLocalDate(date: Date | string) {
  return dayjs(date).toDate();
}

export function preprocessDateInput(val: unknown): string | undefined {
  if (val === undefined || val === null) {
    return undefined;
  }
  
  if (
    typeof val === "object" &&
    val !== null &&
    "year" in val &&
    "month" in val &&
    "day" in val
  ) {
    const { year, month, day } = val as { year: number; month: number; day: number };
    return `${year}-${String(month).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
  }

  if (typeof val === "string") {
    return val;
  }

  return undefined;
}

export function calendarDateToString(val: any): string {
  if (!val || typeof val !== "object") return "";

  if ("year" in val && "month" in val && "day" in val) {
    const year = String(val.year).padStart(4, "0");
    const month = String(val.month).padStart(2, "0");
    const day = String(val.day).padStart(2, "0");
    return `${year}-${month}-${day}`;
  }

  return "";
}

export function formatCalendarDate(val: any): string {
  if (!val || typeof val !== "object") return "";

  if ("year" in val && "month" in val && "day" in val) {
    const year = String(val.year).padStart(4, "0");
    const month = String(val.month).padStart(2, "0");
    const day = String(val.day).padStart(2, "0");
    return `${day}/${month}/${year}`;
  }

  return "";
}
