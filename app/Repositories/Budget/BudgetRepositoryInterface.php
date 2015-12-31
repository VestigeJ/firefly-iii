<?php

namespace FireflyIII\Repositories\Budget;

use Carbon\Carbon;
use FireflyIII\Models\Budget;
use FireflyIII\Models\LimitRepetition;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Interface BudgetRepositoryInterface
 *
 * @package FireflyIII\Repositories\Budget
 */
interface BudgetRepositoryInterface
{
    /**
     * @return void
     */
    public function cleanupBudgets();

    /**
     * Returns the expenses for this budget grouped per day, with the date
     * in "date" (a string, not a Carbon) and the amount in "dailyAmount".
     *
     * @param Budget $budget
     * @param Carbon $start
     * @param Carbon $end
     *
     * @return Collection
     */
    public function getExpensesPerDay(Budget $budget, Carbon $start, Carbon $end);

    /**
     * @param Budget $budget
     *
     * @return Carbon
     */
    public function firstActivity(Budget $budget);

    /**
     * Get a collection of all the limit repetitions belonging to this $budget.
     *
     * @param Budget $budget
     *
     * @return Collection
     */
    public function getBudgetReps(Budget $budget);

    /**
     * Returns the expenses for this budget grouped per month, with the date
     * in "date" (a string, not a Carbon) and the amount in "dailyAmount".
     *
     * @param Budget $budget
     * @param Carbon $start
     * @param Carbon $end
     *
     * @return Collection
     */
    public function getExpensesPerMonth(Budget $budget, Carbon $start, Carbon $end);

    /**
     * Returns an array with the following key:value pairs:
     *
     * yyyy-mm-dd:<amount>
     *
     * Where yyyy-mm-dd is the date and <amount> is the money spent using WITHDRAWALS in the $budget
     * from all the users accounts.
     *
     * @param Budget $budget
     * @param Carbon $start
     * @param Carbon $end
     *
     * @return array
     */
    public function spentPerDay(Budget $budget, Carbon $start, Carbon $end);

    /**
     * @param Budget $budget
     *
     * @return boolean
     */
    public function destroy(Budget $budget);

    /**
     * Returns an array with every budget in it and the expenses for each budget
     * per month.
     *
     * @param Collection $accounts
     * @param Carbon     $start
     * @param Carbon     $end
     *
     * @return array
     */
    public function getBudgetsAndExpensesPerMonth(Collection $accounts, Carbon $start, Carbon $end);

    /**
     * Returns an array with every budget in it and the expenses for each budget
     * per year for.
     *
     * @param Collection $budgets
     * @param Collection $accounts
     * @param Carbon     $start
     * @param Carbon     $end
     *
     * @return array
     */
    public function getBudgetsAndExpensesPerYear(Collection $budgets, Collection $accounts, Carbon $start, Carbon $end);

    /**
     * Takes tags into account.
     *
     * @param Budget $budget
     * @param Carbon $date
     *
     * @return float
     */
    public function expensesOnDay(Budget $budget, Carbon $date);

    /**
     * @return Collection
     */
    public function getActiveBudgets();

    /**
     * Get the budgeted amounts for each budgets in each year.
     *
     * @param Collection $budgets
     * @param Carbon     $start
     * @param Carbon     $end
     *
     * @return Collection
     */
    public function getBudgetedPerYear(Collection $budgets, Carbon $start, Carbon $end);

    /**
     * @param Budget $budget
     * @param Carbon $start
     * @param Carbon $end
     *
     * @return Collection
     */
    public function getBudgetLimitRepetitions(Budget $budget, Carbon $start, Carbon $end);

    /**
     * @param Budget $budget
     *
     * @return Collection
     */
    public function getBudgetLimits(Budget $budget);

    /**
     * @return Collection
     */
    public function getBudgets();

    /**
     * Returns a list of budgets, budget limits and limit repetitions
     * (doubling any of them in a left join)
     *
     * @param Carbon $start
     * @param Carbon $end
     *
     * @return Collection
     */
    public function getBudgetsAndLimitsInRange(Carbon $start, Carbon $end);

    /**
     * @param Budget $budget
     * @param Carbon $start
     * @param Carbon $end
     *
     * @return LimitRepetition|null
     */
    public function getCurrentRepetition(Budget $budget, Carbon $start, Carbon $end);

    /**
     * @param Budget $budget
     *
     * @return Carbon
     */
    public function getFirstBudgetLimitDate(Budget $budget);

    /**
     * @return Collection
     */
    public function getInactiveBudgets();

    /**
     * Returns all the transaction journals for a limit, possibly limited by a limit repetition.
     *
     * @param Budget          $budget
     * @param LimitRepetition $repetition
     * @param int             $take
     *
     * @return LengthAwarePaginator
     */
    public function getJournals(Budget $budget, LimitRepetition $repetition = null, $take = 50);

    /**
     * @deprecated
     *
     * @param Budget $budget
     *
     * @return Carbon
     */
    public function getLastBudgetLimitDate(Budget $budget);

    /**
     * @deprecated
     *
     * @param Budget $budget
     * @param Carbon $date
     *
     * @return float
     */
    public function getLimitAmountOnDate(Budget $budget, Carbon $date);

    /**
     * @param Carbon $start
     * @param Carbon $end
     *
     * @return Collection
     */
    public function getWithoutBudget(Carbon $start, Carbon $end);

    /**
     * @param Carbon $start
     * @param Carbon $end
     *
     * @return mixed
     */
    public function getWithoutBudgetSum(Carbon $start, Carbon $end);

    /**
     *
     * Same as ::spentInPeriod but corrects journals for a set of accounts
     *
     * @param Budget     $budget
     * @param Carbon     $start
     * @param Carbon     $end
     * @param Collection $accounts
     *
     * @return string
     */
    public function balanceInPeriod(Budget $budget, Carbon $start, Carbon $end, Collection $accounts);

    /**
     * @param array $data
     *
     * @return Budget
     */
    public function store(array $data);

    /**
     * @param Budget $budget
     * @param array  $data
     *
     * @return Budget
     */
    public function update(Budget $budget, array $data);

    /**
     * @param Budget $budget
     * @param Carbon $date
     * @param        $amount
     *
     * @return mixed
     */
    public function updateLimitAmount(Budget $budget, Carbon $date, $amount);

}
