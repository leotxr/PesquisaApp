<div>
    <div class="text-left">
        <ul x-data="{ reports: [
    { id: 1, label: 'Quantidade de Avaliações e Atendimentos no X-Clinic por Funcionário', link: '{{route("reports.report-by-employee")}}' },
    { id: 2, label: 'Quantidade de Avaliações e Atendimentos no X-Clinic por Setor', link: '{{route("reports.report-by-sector")}}' },
    { id: 3, label: 'Yellow' },
]}">
            <template x-for="report in reports" :key="report.id">
                <li><a class="space-x-2 cursor-pointer hover:border-b hover:border-b-primary" type="button" :href="report.link"><span x-text="report.id" class="font-bold"></span>:<span x-text="report.label"></span></a></li>
            </template>
        </ul>
    </div>
</div>
