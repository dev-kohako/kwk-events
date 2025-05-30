<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Textarea } from "@/components/ui/textarea";
import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { Input } from "@/components/ui/input";
import "vue-sonner/style.css";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";
import { formatCalendarDate } from "@/utils/date";
import { Icon } from "@iconify/vue";
import { useCreate } from "./useCreate";

const { hours, minutes, isSubmitting, onSubmit } = useCreate();
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Criar evento" />

    <h1
      class="w-full md:max-w-xl text-center sm:text-start text-2xl font-black uppercase mb-4"
    >
      KWK - <span class="font-bold capitalize">Criar Evento</span>
    </h1>
    <Separator />

    <form
      @submit.prevent="onSubmit"
      class="rounded-xl w-full md:max-w-xl border p-4 lg:p-8"
      aria-labelledby="form-title"
    >
      <h1 id="form-title" class="sr-only">Formulário de criação de evento</h1>

      <section aria-labelledby="event-info-heading">
        <h2 id="event-info-heading" class="text-lg font-semibold my-2">
          Informações do evento
        </h2>
        <div class="flex flex-col gap-4">
          <div class="flex flex-col lg:flex-row gap-6">
            <FormField name="eventInfo.name" v-slot="{ componentField }">
              <FormItem class="w-full">
                <FormLabel for="event-name">Nome do Evento *</FormLabel>
                <FormControl>
                  <Input
                    id="event-name"
                    type="text"
                    v-bind="componentField"
                    placeholder="Nome completo do evento."
                    aria-required="true"
                    aria-describedby="event-name-help"
                  />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>
          </div>

          <FormField name="eventInfo.description" v-slot="{ componentField }">
            <FormItem>
              <FormLabel for="event-description">Descrição do evento</FormLabel>
              <FormControl>
                <Textarea
                  id="event-description"
                  placeholder="Digite a descrição do evento."
                  v-bind="componentField"
                  aria-describedby="event-description-help"
                />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
        </div>
      </section>

      <section aria-labelledby="address-info-heading">
        <h2 id="address-info-heading" class="text-lg font-semibold mt-4 mb-2">
          Informações do endereço
        </h2>
        <div class="flex flex-col gap-4">
          <div class="flex flex-col sm:flex-row gap-3 lg:gap-6">
            <FormField name="address.zipcode" v-slot="{ componentField }">
              <FormItem class="w-full">
                <FormLabel for="zipcode">CEP *</FormLabel>
                <FormControl>
                  <Input
                    id="zipcode"
                    type="text"
                    v-bind="componentField"
                    aria-required="true"
                    maxlength="9"
                    aria-describedby="zipcode-help"
                    inputmode="numeric"
                    placeholder="Formato: 00000-000"
                  />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>

            <FormField name="address.address" v-slot="{ componentField }">
              <FormItem class="w-full">
                <FormLabel for="address">Endereço *</FormLabel>
                <FormControl>
                  <Input
                    id="address"
                    type="text"
                    v-bind="componentField"
                    aria-required="true"
                  />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>
          </div>
          <div class="flex flex-col sm:flex-row gap-3 lg:gap-6">
            <FormField name="address.number" v-slot="{ componentField }">
              <FormItem class="w-full">
                <FormLabel for="address-number">Número *</FormLabel>
                <FormControl>
                  <Input
                    id="address-number"
                    type="text"
                    v-bind="componentField"
                    aria-required="true"
                  />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>

            <FormField name="address.city" v-slot="{ componentField }">
              <FormItem class="w-full">
                <FormLabel for="city">Cidade *</FormLabel>
                <FormControl>
                  <Input
                    id="city"
                    type="text"
                    v-bind="componentField"
                    aria-required="true"
                  />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>
          </div>
          <div class="flex lg:gap-6">
            <FormField name="address.state" v-slot="{ componentField }">
              <FormItem class="w-full">
                <FormLabel for="state">Estado *</FormLabel>
                <FormControl>
                  <Input
                    id="state"
                    type="text"
                    v-bind="componentField"
                    aria-required="true"
                    aria-describedby="state-help"
                    placeholder="Sigla do estado (ex: SP, RJ)."
                  />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>
          </div>
          <FormField name="address.complement" v-slot="{ componentField }">
            <FormItem>
              <FormLabel for="complement">Complemento</FormLabel>
              <FormControl>
                <Textarea
                  id="complement"
                  placeholder="Digite o complemento do endereço."
                  v-bind="componentField"
                  aria-describedby="complement-help"
                />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
        </div>
      </section>

      <section aria-labelledby="schedule-info-heading">
        <h2 id="schedule-info-heading" class="text-lg font-semibold mt-4 mb-2">
          Informações do evento
        </h2>
        <div class="flex flex-col gap-4">
          <div class="flex flex-col sm:flex-row gap-3 lg:gap-6">
            <FormField name="schedule.starts_at" v-slot="{ componentField }">
              <FormItem class="w-full">
                <FormLabel for="start-date">Data de Início *</FormLabel>
                <FormControl>
                  <Popover>
                    <PopoverTrigger as-child>
                      <Button
                        id="start-date"
                        variant="outline"
                        class="w-full justify-start text-left font-normal mt-2 min-w-44"
                        :class="{ 'text-muted-foreground': !componentField.modelValue }"
                        aria-haspopup="dialog"
                        aria-expanded="false"
                        aria-controls="start-date-calendar"
                      >
                        <Icon
                          icon="mdi:calendar"
                          width="16"
                          height="16"
                          aria-hidden="true"
                        />
                        {{
                          componentField.modelValue
                            ? formatCalendarDate(componentField.modelValue)
                            : "Escolha uma data"
                        }}
                      </Button>
                    </PopoverTrigger>
                    <PopoverContent
                      id="start-date-calendar"
                      class="w-auto p-0"
                      role="dialog"
                      aria-modal="true"
                    >
                      <Calendar
                        v-bind="componentField"
                        :mode="'single'"
                        initial-focus
                        aria-labelledby="start-date-label"
                      />
                      <span id="start-date-label" class="sr-only"
                        >Selecione a data de início</span
                      >
                    </PopoverContent>
                  </Popover>
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>

            <FormField name="schedule.starts_time.hour" v-slot="{ componentField }">
              <FormItem class="w-full">
                <FormLabel>Hora *</FormLabel>
                <FormControl>
                  <Select v-bind="componentField">
                    <SelectTrigger class="w-full">
                      <SelectValue placeholder="Hora" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectGroup>
                        <SelectItem
                          v-for="h in hours"
                          :key="h"
                          :value="String(h).padStart(2, '0')"
                        >
                          {{ String(h).padStart(2, "0") }}
                        </SelectItem>
                      </SelectGroup>
                    </SelectContent>
                  </Select>
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>

            <FormField name="schedule.starts_time.minute" v-slot="{ componentField }">
              <FormItem class="w-full">
                <FormLabel>Minuto *</FormLabel>
                <FormControl>
                  <Select v-bind="componentField">
                    <SelectTrigger class="w-full">
                      <SelectValue placeholder="Minuto" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectGroup>
                        <SelectItem
                          v-for="m in minutes"
                          :key="m"
                          :value="String(m).padStart(2, '0')"
                        >
                          {{ String(m).padStart(2, "0") }}
                        </SelectItem>
                      </SelectGroup>
                    </SelectContent>
                  </Select>
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>
          </div>

          <div class="flex flex-col sm:flex-row gap-3 lg:gap-6">
            <FormField name="schedule.ends_at" v-slot="{ componentField }">
              <FormItem class="w-full">
                <FormLabel for="end-date">Data de Fim *</FormLabel>
                <FormControl>
                  <Popover>
                    <PopoverTrigger as-child>
                      <Button
                        id="end-date"
                        variant="outline"
                        class="w-full justify-start text-left font-normal mt-2 min-w-44"
                        :class="{ 'text-muted-foreground': !componentField.modelValue }"
                        aria-haspopup="dialog"
                        aria-expanded="false"
                        aria-controls="end-date-calendar"
                      >
                        <Icon
                          icon="mdi:calendar"
                          width="16"
                          height="16"
                          aria-hidden="true"
                        />
                        {{
                          componentField.modelValue
                            ? formatCalendarDate(componentField.modelValue)
                            : "Escolha uma data"
                        }}
                      </Button>
                    </PopoverTrigger>
                    <PopoverContent
                      id="end-date-calendar"
                      class="w-auto p-0"
                      role="dialog"
                      aria-modal="true"
                    >
                      <Calendar
                        v-bind="componentField"
                        :mode="'single'"
                        initial-focus
                        aria-labelledby="end-date-label"
                      />
                      <span id="end-date-label" class="sr-only"
                        >Selecione a data de término</span
                      >
                    </PopoverContent>
                  </Popover>
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>

            <FormField name="schedule.ends_time.hour" v-slot="{ componentField }">
              <FormItem class="w-full">
                <FormLabel>Hora *</FormLabel>
                <FormControl>
                  <Select v-bind="componentField">
                    <SelectTrigger class="w-full">
                      <SelectValue placeholder="Hora" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectGroup>
                        <SelectItem
                          v-for="h in hours"
                          :key="h"
                          :value="String(h).padStart(2, '0')"
                        >
                          {{ String(h).padStart(2, "0") }}
                        </SelectItem>
                      </SelectGroup>
                    </SelectContent>
                  </Select>
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>

            <FormField name="schedule.ends_time.minute" v-slot="{ componentField }">
              <FormItem class="w-full">
                <FormLabel>Minuto *</FormLabel>
                <FormControl>
                  <Select v-bind="componentField">
                    <SelectTrigger class="w-full">
                      <SelectValue placeholder="Minuto" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectGroup>
                        <SelectItem
                          v-for="m in minutes"
                          :key="m"
                          :value="String(m).padStart(2, '0')"
                        >
                          {{ String(m).padStart(2, "0") }}
                        </SelectItem>
                      </SelectGroup>
                    </SelectContent>
                  </Select>
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>
          </div>
        </div>
      </section>

      <FormField name="vacancy.max_subscription" v-slot="{ componentField }">
        <FormItem class="w-full mt-3">
          <FormLabel for="max-subscription">Vagas disponíveis *</FormLabel>
          <FormControl>
            <Input
              id="max-subscription"
              type="number"
              v-bind="componentField"
              min="1"
              aria-required="true"
              aria-describedby="max-subscription-help"
              placeholder="Número mínimo de vagas: 1"
            />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <div class="flex items-center justify-end mt-6">
        <Button type="submit" class="ml-4" aria-label="Criar novo evento">
          {{ isSubmitting ? "Criando" : "Criar Evento" }}
        </Button>
      </div>
    </form>
  </AuthenticatedLayout>
</template>
