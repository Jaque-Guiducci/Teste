<?php

declare(strict_types=1);

namespace Devitools\Database\Migration;

use Devitools\Database\Migration;
use Devitools\Database\Schema;
use Devitools\Database\Table;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class TableCreate
 *
 * @package Devitools\Database\Migration
 */
abstract class TableCreate extends Migration
{
    /**
     * @var bool
     */
    protected bool $withUuid = true;

    /**
     * @var bool
     */
    protected bool $withTimestamps = true;

    /**
     * @var bool
     */
    protected bool $withResponsible = true;

    /**
     * @return string
     */
    abstract protected function table(): string;

    /**
     * @param Table $table
     *
     * @return void
     */
    abstract protected function withStatements(Table $table): void;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table())) {
            return;
        }
        Schema::create($this->table(), function (Blueprint $blueprint) {
            $table = Table::make($blueprint);

            if ($this->withUuid) {
                $table->efficientUuid(__BINARY_KEY__)->primary();
                $table->string(__PRIMARY_KEY__)->unique();

                if (config('app.counter')) {
                    $table->bigInteger('counter');
                }
            }

            $this->withStatements($table);

            if ($this->withTimestamps) {
                $this->timestamps($table);
            }

            if (config('app.no-responsible')) {
                return;
            }

            if ($this->withResponsible) {
                $this->responsible($table);
            }
        });
    }

    /**
     * @param Table $table
     */
    private function timestamps(Table $table)
    {
        $table->timestamp(config('devitools.schema.updatedAt', 'updatedAt'))->nullable();
        $table->timestamp(config('devitools.schema.createdAt', 'createdAt'))->nullable();
        $table->timestamp(config('devitools.schema.deletedAt', 'deletedAt'))->nullable();
    }

    /**
     * @param Table $table
     */
    private function responsible(Table $table)
    {
        $table->string(config('devitools.schema.updatedBy', 'updatedBy'))->nullable();
        $table->string(config('devitools.schema.createdBy', 'createdBy'))->nullable();
        $table->string(config('devitools.schema.deletedBy', 'deletedBy'))->nullable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table());
    }
}
