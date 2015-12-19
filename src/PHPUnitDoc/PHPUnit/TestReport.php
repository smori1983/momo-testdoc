<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

class TestReport
{
    const START = 'START';
    const SUCCESS = 'SUCCESS';
    const ERROR = 'ERROR';
    const FAILURE = 'FAILURE';
    const INCOMPLETE = 'INCOMPLETE';
    const RISKY = 'RISKY';
    const SKIPPED = 'SKIPPED';

    /**
     * レポートの凍結状態を保持する。
     *
     * @var bool
     */
    private $freezed = false;

    /**
     * @var string[]
     */
    private $history = array();

    /**
     * @var null|int
     */
    private $currentTestIndex = null;

    /**
     * @var null|array
     */
    private $providedData = null;

    /**
     * @var null|array
     */
    private $tableData = null;

    /**
     * レポートを凍結する。
     *
     * 凍結後は、テスト結果の登録等、状態の変更ができない。
     */
    public function freeze()
    {
        $this->freezed = true;
    }

    public function startTest()
    {
        if ($this->freezed) {
            throw new \RuntimeException('Cannot call start test after freezed.');
        }

        if (is_null($this->currentTestIndex)) {
            $this->currentTestIndex = 0;
        } else {
            $this->currentTestIndex += 1;
        }

        $this->history[$this->currentTestIndex] = self::START;

        return $this;
    }

    public function endTest()
    {
        if ($this->freezed) {
            throw new \RuntimeException('Cannot call end test after freezed.');
        }

        if (is_null($this->currentTestIndex) || $this->history[$this->currentTestIndex] === self::SUCCESS) {
            throw new \RuntimeException('Invalid timing for call end test.');
        }

        if ($this->history[$this->currentTestIndex] === self::START) {
            $this->history[$this->currentTestIndex] = self::SUCCESS;
        }
    }

    public function markError()
    {
        if (is_null($this->currentTestIndex) || $this->history[$this->currentTestIndex] !== self::START) {
            throw new \RuntimeException('Invalid timing for mark Error.');
        }

        $this->history[$this->currentTestIndex] = self::ERROR;

        return $this;
    }

    public function markFailure()
    {
        if (is_null($this->currentTestIndex) || $this->history[$this->currentTestIndex] !== self::START) {
            throw new \RuntimeException('Invalid timing for mark Failure.');
        }

        $this->history[$this->currentTestIndex] = self::FAILURE;

        return $this;
    }

    public function markIncomplete()
    {
        if (is_null($this->currentTestIndex) || $this->history[$this->currentTestIndex] !== self::START) {
            throw new \RuntimeException('Invalid timing for mark Incomplete.');
        }

        $this->history[$this->currentTestIndex] = self::INCOMPLETE;

        return $this;
    }

    public function markRisky()
    {
        if (is_null($this->currentTestIndex) || $this->history[$this->currentTestIndex] !== self::START) {
            throw new \RuntimeException('Invalid timing for mark Risky.');
        }

        $this->history[$this->currentTestIndex] = self::RISKY;

        return $this;
    }

    public function markSkipped()
    {
        if (is_null($this->currentTestIndex) || $this->history[$this->currentTestIndex] !== self::START) {
            throw new \RuntimeException('Invalid timing for mark Skipped.');
        }

        $this->history[$this->currentTestIndex] = self::SKIPPED;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * @throw \OutOfRangeException
     */
    public function isSuccessAt($index)
    {
        if (!array_key_exists($index, $this->history)) {
            throw new \OutOfRangeException(sprintf('Index %s does not exist in test history.', $index));
        }

        return $this->history[$index] === self::SUCCESS;
    }

    /**
     * テストがすべて成功したかどうかを確認する。
     *
     * - テスト件数が0件の場合はfalse
     *
     * @return bool
     */
    public function isAllSuccess()
    {
        if ($this->getTestCount() === 0) {
            return false;
        }

        return $this->getTestCount() === $this->getSuccessCount();
    }

    /**
     * テスト件数を取得する。
     *
     * @return int
     */
    public function getTestCount()
    {
        return count($this->history);
    }

    /**
     * テストが成功した件数を取得する。
     *
     * @return int
     */
    public function getSuccessCount()
    {
        $result = 0;

        foreach (array_keys($this->getHistory()) as $index) {
            if ($this->isSuccessAt($index)) {
                $result += 1;
            }
        }

        return $result;
    }

    /**
     * データプロバイダのデータをセットする。
     *
     * @param array $data
     */
    public function setProvidedData(array $data)
    {
        if ($this->freezed) {
            throw new \RuntimeException('Cannot set provided data after freezed.');
        }

        $this->providedData = $data;
    }

    /**
     * データプロバイダのデータを保持しているかを確認する。
     *
     * @return bool
     */
    public function hasProvidedData()
    {
        return is_array($this->providedData);
    }

    /**
     * データプロバイダのデータを取得する。
     *
     * @return array
     */
    public function getProvidedData()
    {
        return $this->providedData;
    }

    /**
     * テーブルデータをセットする。
     *
     * @param array $data
     */
    public function setTableData(array $data)
    {
        if ($this->freezed) {
            throw new \RuntimeException('Cannot set table data after freezed.');
        }

        $this->tableData = $data;
    }

    /**
     * テーブルデータを保持しているかを確認する。
     *
     * @return bool
     */
    public function hasTableData()
    {
        return is_array($this->tableData);
    }

    /**
     * テーブルデータを取得する。
     *
     * @return array
     */
    public function getTableData()
    {
        return $this->tableData;
    }
}
