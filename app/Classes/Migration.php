<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 07.08.2019
 * Time: 15:23
 */

namespace App\Classes;

use DB;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Migrations\Migration as LaravelMigration;
use Throwable;

class Migration extends LaravelMigration {
    protected $callerFile;
    protected $script;
    protected $transactionMode = true;
    protected $reversed = false;
    protected $sqls = [];
    protected $vars;

    /**
     * @return self
     */
    protected function process(): self
    {
        $this->callerFile = $this->getCallerFile();

        $this->sqls[] = $this->bind();

        if (!$this->reversed) {
            $sql = $this->setScript('data')->bind();
            if ($sql) {
                $this->sqls[] = $sql;
            }

            $sql = $this->setScript(app()->environment())->bind();
            if ($sql) {
                $this->sqls[] = $sql;
            }
        }

        if ($this->isTransactionMode()) {
            DB::transaction(function () {
                $this->execute();
            });
        }
        else {
            $this->execute();
        }

        return $this;
    }

    /**
     * Reverse the migration
     * @param array $vars
     * @return self
     */
    public function reverse($vars = []): self
    {
        $this->vars = $vars;
        $this->reversed = true;
        $this->process();

        return $this;
    }

    /**
     * Run the migration
     * @param array $vars
     * @return self
     */
    public function run($vars = []): self
    {
        $this->vars = $vars;
        $this->process();

        return $this;
    }

    /**
     * Get full script path
     * @param string $file
     * @return string|null
     */
    protected function getScriptContent($file = null): ?string
    {
        if ($file) {
            $script = $file;
        }
        else {
            if ($this->script) {
                $script = $this->script;
            }
            else {
                $script = $this->reversed ? 'reverse' : 'run';
            }
            $script = basename($script, '.sql') . '.sql';
        }

        try {
            return File::get(implode(DIRECTORY_SEPARATOR, [
                dirname($this->callerFile),
                basename($this->callerFile, '.php'),
                $script,
            ]));
        }
        catch (FileNotFoundException $exception) {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getScript(): string
    {
        return $this->script;
    }

    /**
     * @param string $script
     * @return self
     */
    public function setScript($script): self
    {
        $this->script = $script;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTransactionMode(): bool
    {
        return $this->transactionMode;
    }

    /**
     * @param bool $transactionMode
     * @return self
     */
    public function setTransactionMode(bool $transactionMode): self
    {
        $this->transactionMode = $transactionMode;

        return $this;
    }

    /**
     * @return string|null
     */
    protected function bind(): ?string
    {
        $sql = $this->getScriptContent();

        if ($sql === null || !preg_match('~\S+~', $sql)) {
            return null;
        }

        $sql = preg_replace_callback(
            '~@include\s+(?:\'(.+?)\'|"(.+?)"|([\w/!#$%+,.@^-]+))~u',
            function ($matches) {
                $file = $matches[1] ?: $matches[2] ?: $matches[3];
                return $this->getScriptContent($file);
            },
            $sql
        );

        if ($this->vars) {
            $sql = preg_replace_callback('~{\$(\w+)}~', function ($matches) {
                return $this->vars[$matches[1]];
            }, $sql);
        }

        return $sql;
    }

    protected function execute(): void
    {
        foreach ($this->sqls as $sql) {
            DB::getPdo()->exec($sql);
        }
    }

    /**
     * @return string
     */
    protected function getCallerFile(): string
    {
        [, , $caller] = debug_backtrace(false, 3);

        return $caller['file'];
    }
}
