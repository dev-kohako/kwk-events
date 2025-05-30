<mjml>
  <mj-head>
    <mj-title>Confirmação de E-mail</mj-title>
    <mj-preview>Confirme seu e-mail para ativar sua conta</mj-preview>
    <mj-attributes>
      <mj-all font-family="Helvetica Neue, Arial, sans-serif" />
      <mj-text font-size="16px" line-height="1.5" color="#374151" />
      <mj-button background-color="#ef4444" color="white" font-size="16px" font-weight="bold" border-radius="6px" padding="16px 32px" />
    </mj-attributes>
    <mj-style inline="inline">
      .footer {
        font-size: 12px;
        color: #9ca3af;
      }
    </mj-style>
  </mj-head>

  <mj-body background-color="#f9fafb">
    <mj-section padding="32px 0">
      <mj-column width="100%">
        <mj-text align="center" font-size="24px" font-weight="bold" color="#111827">
          Verifique seu e-mail
        </mj-text>
        <mj-divider border-color="#e5e7eb" />
      </mj-column>
    </mj-section>

    <mj-section background-color="#ffffff" border-radius="8px" padding="32px" css-class="card">
      <mj-column>
        <mj-text font-size="18px" font-weight="bold" color="#111827">
          Olá {{ $user->name }},
        </mj-text>

        <mj-text>
          Obrigado por se cadastrar. Para concluir o processo, clique no botão abaixo e confirme seu endereço de e-mail.
        </mj-text>

        <mj-button href="{{ $url }}">
          Verificar E-mail
        </mj-button>

        <mj-text color="#6b7280" font-size="14px" padding-top="16px">
          Se você não criou uma conta, pode ignorar este e-mail com segurança.
        </mj-text>
      </mj-column>
    </mj-section>

    <mj-section padding="24px 0">
      <mj-column>
        <mj-divider border-color="#e5e7eb" />
        <mj-text align="center" css-class="footer">
          {{ config('app.name') }}<br/>
          &copy; {{ now()->year }} Todos os direitos reservados.
        </mj-text>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
