<?php
namespace GeekDC\Sensitive;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SensitiveHandle
{
    private $wordMap;

    public function __construct()
    {
        $this->setWords();
    }

    public function match($content)
    {
        $len = mb_strlen($content);

        $wordMap = $this->wordMap;

        for ($i=0; $i < $len; $i++) {
            $txt = mb_substr($content, $i, 1);

            if ($this->checkIgnoreWords($txt)) {
                continue;
            }

            if (!isset($wordMap[$txt])) {
                // reset hashmap
                $wordMap = isset($this->wordMap[$txt]) ? $this->wordMap[$txt] : $this->wordMap;

                continue;
            }

            if ($wordMap[$txt]['end']) {
                return true;
            }
            $wordMap = $wordMap[$txt];
        }

        return false;
    }

    /**
     * 设置敏感词
     *
     * @return $words
     */
    private function setWords()
    {
        $this->wordMap = Cache::remember(config('sensitive.key'), config('sensitive.cache'), function () {
            $words = DB::table(config('sensitive.table'))->where('is_del', 0)->pluck(config('sensitive.field'))->toArray();

            $workMap = [];
            foreach ($words as $word) {
                $this->addWordMap($word, $workMap);
            }

            return $workMap;
        });
    }

    private function addWordMap($word, &$wordMap)
    {
        $len = mb_strlen($word);

        for ($i = 0; $i < $len; $i++) {
            $txt = mb_substr($word, $i, 1);

            // 已存在
            if (isset($wordMap[$txt])) {
                if ($i == ($len - 1)) {
                    $wordMap[$txt]['end'] = 1;
                }
            } else {
                // 不存在
                if ($i == ($len - 1)) {
                    $wordMap[$txt] = [];
                    $wordMap[$txt]['end'] = 1;
                } else {
                    $wordMap[$txt] = [];
                    $wordMap[$txt]['end'] = 0;
                }
            }

            $wordMap = &$wordMap[$txt];
        }
    }

    private function checkIgnoreWords($txt)
    {
        return in_array($txt, config('sensitive.ignore'));
    }
}
